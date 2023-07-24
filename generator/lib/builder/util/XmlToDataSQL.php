<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */


/**
 * A Class that is used to parse an data dump XML file and create SQL using a DataSQLBuilder class.
 *
 * @author     Hans Lellelid <hans@xmpl.org> (Propel)
 * @version    $Revision$
 * @package    propel.generator.builder.util
 */
class XmlToDataSQL extends AbstractHandler
{

    /**
     * The output writer for the SQL file.
     */
    private ?\Writer $sqlWriter = null;

    /**
     * The classname of the static class that will perform the building.
     *
     * This is needed because there are some pre/post methods that get called
     * on the static class.
     */
    private ?string $builderClazz = null;

    /**
     * The name of the current table being processed.
     *
     * @var        string
     */
    private $currTableName;

    /**
     * The DataSQLBuilder for the current table.
     */
    private ?\DataModelBuilder $currBuilder = null;

    /**
     * Expat Parser.
     *
     * @var        ExpatParser
     */
    public $parser;

    /**
     * Flag for enabling debug output to aid in parser tracing.
     */
    final public const DEBUG = false;

    /**
     * Construct new XmlToDataSQL class.
     *
     * This class is passed the Database object so that it knows what to expect from
     * the XML file.
     *
     * @param Database        $database
     * @param GeneratorConfig $generatorConfig
     * @param string          $encoding Database encoding
     */
    public function __construct(private readonly Database $database, private readonly GeneratorConfig $generatorConfig, private $encoding = 'iso-8859-1')
    {
    }

    /**
     * Transform the data dump input file into SQL and writes it to the output stream.
     *
     *
     * @throws BuildException
     */
    public function transform(PhingFile $xmlFile, Writer $out)
    {
        $this->sqlWriter = $out;

        // Reset some vars just in case this is being run multiple times.
        $this->currTableName = $this->currBuilder = null;

        $this->builderClazz = $this->generatorConfig->getBuilderClassname('datasql');

        try {
            $fr = new FileReader($xmlFile);
        } catch (Exception $e) {
            throw new BuildException("XML File not found: " . $xmlFile->getAbsolutePath());
        }

        $br = new BufferedReader($fr);

        $this->parser = new ExpatParser($br);
        $this->parser->parserSetOption(XML_OPTION_CASE_FOLDING, 0);
        $this->parser->setHandler($this);

        try {
            $this->parser->parse();
        } catch (Exception $e) {
            print $e->getMessage() . "\n";
            $br->close();
        }
        $br->close();
    }

    /**
     * Handles opening elements of the xml file.
     */
    public function startElement($name, $attributes)
    {
        try {
            if ($name == "dataset") {
                // Clear any start/end DLL
                call_user_func([$this->builderClazz, 'reset']);
                $this->sqlWriter->write(call_user_func([$this->builderClazz, 'getDatabaseStartSql']));
            } else {

                // we're processing a row of data
                // where tag name is phpName e.g. <BookReader .... />

                $table = $this->database->getTableByPhpName($name);

                $columnValues = [];
                foreach ($attributes as $name => $value) {
                    $col = $table->getColumnByPhpName($name);
                    $columnValues[] = new ColumnValue($col, iconv('utf-8', $this->encoding, (string) $value));
                }

                $data = new DataRow($table, $columnValues);

                if ($this->currTableName !== $table->getName()) {
                    // new table encountered

                    if ($this->currBuilder !== null) {
                        $this->sqlWriter->write($this->currBuilder->getTableEndSql());
                    }

                    $this->currTableName = $table->getName();
                    $this->currBuilder = $this->generatorConfig->getConfiguredBuilder($table, 'datasql');

                    $this->sqlWriter->write($this->currBuilder->getTableStartSql());
                }

                // Write the SQL
                $this->sqlWriter->write($this->currBuilder->buildRowSql($data));
            }
        } catch (Exception $e) {
            // Exceptions have traditionally not bubbled up nicely from the expat parser,
            // so we also print the stack trace here.
            print $e;
            throw $e;
        }
    }


    /**
     * Handles closing elements of the xml file.
     *
     * @param   $name The local name (without prefix), or the empty string if
     *         Namespace processing is not being performed.
     */
    public function endElement($name)
    {
        if (self::DEBUG) {
            print("endElement(" . $name . ") called\n");
        }
        if ($name == "dataset") {
            if ($this->currBuilder !== null) {
                $this->sqlWriter->write($this->currBuilder->getTableEndSql());
            }
            $this->sqlWriter->write(call_user_func([$this->builderClazz, 'getDatabaseEndSql']));
        }
    }
} // XmlToData

/**
 * "inner class"
 *
 * @package    propel.generator.builder.util
 */
class DataRow
{
    public function __construct(private readonly Table $table, private $columnValues)
    {
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getColumnValues()
    {
        return $this->columnValues;
    }
}

/**
 * "inner" class
 *
 * @package    propel.generator.builder.util
 */
class ColumnValue
{
    public function __construct(private readonly Column $col, private $val)
    {
    }

    public function getColumn()
    {
        return $this->col;
    }

    public function getValue()
    {
        return $this->val;
    }
}
