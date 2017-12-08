<?php

/**
 * Class ModelTestCase
 * Base class for Model test cases
 */
abstract class CIUnit_DBTestCase extends CIUnit_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->CI->db = load_class([
            'class' => 'db',
            'object' => get_instance()->load->database('', true)
        ]);
        $this->CI->db->trans_start();
    }

    protected function tearDown()
    {
        $this->CI->db->trans_rollback();
        $this->CI->db->close();
        parent::tearDown();
    }

    /**
     * @param $tableName string
     * @param $fixture array
     */
    protected function tbFixture($tableName, $fixture)
    {
        CIUnit::$fixture->load($tableName, $fixture);
    }

    /**
     * @param $tableName string
     * @param $fixture array
     * @param null $db CI_DB_driver
     */
    protected function assertTable($tableName, $fixture, $db = null)
    {
        if (sizeof($fixture) == 0) {
            $this->assertTableRowCount($tableName, 0, $db);
        } else {
            $columnHeader = array_keys($fixture[0]);

            $db = is_null($db) ? $this->CI->db : $db;
            $query = $db->select($columnHeader)->from($tableName)->get();

            $tableData = $query && $query->num_rows() > 0 ? $query->result() : [];

            foreach ($fixture as $rowIndex => $row) {
                $fixture[$rowIndex] = (object) $row;
            }

            $this->assertEquals($fixture, $tableData);
        }
    }

    /**
     * @param $tableName string
     * @param $count integer
     * @param null $db CI_DB_driver
     */
    protected function assertTableRowCount($tableName, $count, $db = null)
    {
        $db = is_null($db) ? $this->CI->db : $db;

        $query = $db->select("COUNT(*) as numOfRows")->from($tableName)->get();

        $this->assertEquals($count, $query->result()[0]->numOfRows);
    }
}
