<?php

/*
 *  Copyright 2020 Mindstellar Osclass
 *  Maintained and supported by Mindstellar Community
 *  https://github.com/mindstellar/Osclass
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * LatestSearches DAO
 */
class LatestSearches extends DAO
{
    /**
     *
     * @var \LatestSearches
     */
    private static $instance;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('t_latest_searches');
        $array_fields = array(
            'd_date',
            's_search'
        );
        $this->setFields($array_fields);
    }

    /**
     * @return \LatestSearches
     */
    public static function newInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Get last searches, given a limit.
     *
     * @access public
     *
     * @param int $limit
     *
     * @return array|bool
     * @since  unknown
     *
     */
    public function getSearches($limit = 20)
    {
        $this->dao->select('d_date, s_search, COUNT(s_search) as i_total');
        $this->dao->from($this->getTableName());
        $this->dao->groupBy('s_search');
        $this->dao->orderBy('d_date', 'DESC');
        $this->dao->limit($limit);
        $result = $this->dao->get();

        if ($result == false) {
            return false;
        }

        return $result->result();
    }

    /**
     * Get last searches, given since time.
     *
     * @access public
     *
     * @param int $time
     *
     * @return array|bool
     * @since  unknown
     *
     */
    public function getSearchesByDate($time = null, $limit = 20)
    {
        if ($time == null) {
            $time = time() - (7 * 24 * 3600);
        }

        $this->dao->select('d_date, s_search, COUNT(s_search) as i_total');
        $this->dao->from($this->getTableName());
        $this->dao->where('d_date', date('Y-m-d H:i:s', $time));
        $this->dao->groupBy('s_search');
        $this->dao->orderBy('d_date', 'DESC');
        $this->dao->limit($limit);
        $result = $this->dao->get();

        if ($result == false) {
            return false;
        }

        return $result->result();
    }

    /**
     * Purge n last searches.
     *
     * @access public
     *
     * @param int $number
     *
     * @return bool
     * @since  unknown
     */
    public function purgeNumber($number = null)
    {
        if ($number == null) {
            return false;
        }

        $this->dao->select('d_date');
        $this->dao->from($this->getTableName());
        $this->dao->groupBy('s_search');
        $this->dao->orderBy('d_date', 'DESC');
        $this->dao->limit($number, 1);
        $result = $this->dao->get();
        $last   = $result->row();

        if ($result == false) {
            return false;
        }

        if ($result->numRows() == 0) {
            return false;
        }

        return $this->purgeDate($last['d_date']);
    }

    /**
     * Purge all searches by date.
     *
     * @access public
     *
     * @param string $date
     *
     * @return bool
     * @since  unknown
     */
    public function purgeDate($date = null)
    {
        if ($date == null) {
            return false;
        }

        $this->dao->from($this->getTableName());
        $this->dao->where('d_date <= ' . $this->dao->escape($date));

        return $this->dao->delete();
    }
}

/* file end: ./oc-includes/osclass/model/LatestSearches.php */
