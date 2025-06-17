<?php
require_once __DIR__ . '/dbConfig.php';

    abstract class Model {
        protected static $table = '';
        protected static $rules = []; // e.g., ['name' => 'string|required']
        protected static $timestamps = true;

        protected static function validate($data, $strict = false) {
            $errors = [];

            foreach (static::$rules as $field => $rules) {
                if (!$strict && !array_key_exists($field, $data)) {
                    continue;
                }

                $rulesArr = explode('|', $rules);
                $value = $data[$field] ?? null;

                foreach ($rulesArr as $rule) {
                    if ($rule === 'required' && ($value === null || $value === '')) {
                        $errors[] = "$field is required.";
                    }

                    if ($value !== null && $rule === 'string' && !is_string($value)) {
                        $errors[] = "$field must be a string.";
                    }

                    if ($value !== null && $rule === 'int' && !is_numeric($value)) {
                        $errors[] = "$field must be an integer.";
                    }

                    if ($value !== null && $rule === 'date' && !preg_match('/^\d{4}-\d{2}-\d{2}( \d{2}:\d{2}:\d{2})?$/', $value)) {
                        $errors[] = "$field must be a valid date in YYYY-MM-DD or YYYY-MM-DD HH:MM:SS format.";
                    }


                    if (str_starts_with($rule, 'min:') && is_numeric($value)) {
                        $min = (int)explode(':', $rule)[1];
                        if ($value < $min) $errors[] = "$field must be at least $min.";
                    }

                    if (str_starts_with($rule, 'max:') && is_numeric($value)) {
                        $max = (int)explode(':', $rule)[1];
                        if ($value > $max) $errors[] = "$field must be no more than $max.";
                    }

                    if (str_starts_with($rule, 'regex:')) {
                        $pattern = substr($rule, 6);
                        if (!preg_match($pattern, $value)) {
                            $errors[] = "$field format is invalid.";
                        }
                    }

                    if (str_starts_with($rule, 'enum:')) {
                        $allowed = explode(',', explode(':', $rule)[1]);
                        if (!in_array($value, $allowed)) {
                            $errors[] = "$field must be one of: " . implode(', ', $allowed);
                        }
                    }

                    if (str_starts_with($rule, 'unique:')) {
                        [$__, $table, $column] = explode(':', str_replace(',', ':', $rule));
                        $db = new Database();
                        $conn = $db -> connect();
                        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM $table WHERE $column = ?");
                        $stmt->bind_param('s', $value);
                        $stmt->execute();
                        $result = $stmt->get_result()->fetch_assoc();
                        $stmt->close();
                        $conn->close();

                        if ($result['count'] > 0) {
                            $errors[] = "$field must be unique.";
                        }
                    }
                }
            }

            if (!empty($errors)) {
                throw new Exception("Validation failed: " . implode(' ', $errors));
            }
        }

        public static function create($data) {
            if (static::$timestamps) {
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['updated_at'] = date('Y-m-d H:i:s');
            }

            static::validate($data);

            return static::insert(static::$table, $data);
        }

        public static function update($criteria, $newData) {
            if (static::$timestamps) {
                $newData['updated_at'] = date('Y-m-d H:i:s');
            }

            static::validate($newData);

            return static::performUpdate(static::$table, $criteria, $newData);
        }

        public static function find($criteria = []) {
            return static::performFind(static::$table, $criteria);
        }

        public static function findOne($criteria = []) {
            $results = static::find($criteria);
            return $results ? $results[0] : null;
        }

        public static function delete($criteria) {
            return static::performDelete(static::$table, $criteria);
        }

        // --- Internals for reusability ---
        protected static function insert($table, $data) {
            $db = new Database();
            $conn = $db -> connect();
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), '?'));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) die("Prepare failed: " . $conn->error);

            $types = str_repeat('s', count($data));
            $stmt->bind_param($types, ...array_values($data));
            $result = $stmt->execute();

            $stmt->close();
            $conn->close();

            return $result;
        }

        protected static function performUpdate($table, $criteria, $newData) {
            $db = new Database();
            $conn = $db -> connect();
            $set = implode(", ", array_map(fn($k) => "$k = ?", array_keys($newData)));
            $where = implode(" AND ", array_map(fn($k) => "$k = ?", array_keys($criteria)));

            $sql = "UPDATE $table SET $set WHERE $where";
            $stmt = $conn->prepare($sql);
            if (!$stmt) die("Prepare failed: " . $conn->error);

            $types = str_repeat('s', count($newData) + count($criteria));
            $params = array_merge(array_values($newData), array_values($criteria));
            $stmt->bind_param($types, ...$params);

            $result = $stmt->execute();
            $stmt->close();
            $conn->close();

            return $result;
        }

        protected static function performFind($table, $criteria = []) {
            $db = new Database();
            $conn = $db -> connect();
            $sql = "SELECT * FROM $table";

            if (!empty($criteria)) {
                $conditions = array_map(fn($k) => "$k = ?", array_keys($criteria));
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $stmt = $conn->prepare($sql);
            if (!$stmt) die("Prepare failed: " . $conn->error);

            if (!empty($criteria)) {
                $types = str_repeat('s', count($criteria));
                $stmt->bind_param($types, ...array_values($criteria));
            }

            $stmt->execute();
            $result = $stmt->get_result();

            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            $stmt->close();
            $conn->close();

            return $rows;
        }

        protected static function performDelete($table, $criteria) {
            $db = new Database();
            $conn = $db -> connect();
            $where = implode(" AND ", array_map(fn($k) => "$k = ?", array_keys($criteria)));

            $sql = "DELETE FROM $table WHERE $where";
            $stmt = $conn->prepare($sql);
            if (!$stmt) die("Prepare failed: " . $conn->error);

            $types = str_repeat('s', count($criteria));
            $stmt->bind_param($types, ...array_values($criteria));

            $result = $stmt->execute();
            $stmt->close();
            $conn->close();

            return $result;
        }

        public static function query() {
            return new QueryBuilder(static::$table);
        }

    }

    class QueryBuilder {
        private $table;
        private $conditions = [];
        private $columns = ['*'];

        private $limit = null;
        private $page = 1;
        private $pageSize = 10;

        private $sortKey = null;
        private $sortOrder = 'ASC';

        private $searchTerm = null;
        private $searchFields = [];

        public function __construct($table) {
            $this->table = $table;
        }

        public function select(...$columns) {
            if (!empty($columns)) {
                $this->columns = $columns;
            }
            return $this;
        }

        public function where($field, $operatorOrValue, $value = null, $boolean = 'AND') {
            if ($value === null) {
                $value = $operatorOrValue;
                $operator = '=';
            } else {
                $operator = $operatorOrValue;
            }

            $this->conditions[] = [
                'boolean' => strtoupper($boolean),
                'field' => $field,
                'operator' => $operator,
                'value' => $value
            ];

            return $this;
        }

        public function orWhere($field, $operatorOrValue, $value = null) {
            return $this->where($field, $operatorOrValue, $value, 'OR');
        }

        public function limit($number) {
            $this->limit = (int)$number;
            return $this;
        }

        public function paginate($page = 1, $pageSize = 10) {
            $this->page = max(1, $page);
            $this->pageSize = max(1, $pageSize);
            return $this;
        }

        public function orderBy($column, $order = 'asc') {
            $this->sortKey = $column;
            $this->sortOrder = strtolower($order) === 'desc' ? 'DESC' : 'ASC';
            return $this;
        }

        public function search($term, array $fields) {
            $this->searchTerm = $term;
            $this->searchFields = $fields;
            return $this;
        }

        public function getWithPagination() {
            $db = new Database();
            $conn = $db->connect();

            $sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(', ', $this->columns) . " FROM " . $this->table;

            $params = [];
            $whereParts = [];

            // Conditions
            foreach ($this->conditions as $index => $cond) {
                $prefix = $index === 0 ? '' : ' ' . $cond['boolean'] . ' ';
                $whereParts[] = $prefix . "{$cond['field']} {$cond['operator']} ?";
                $params[] = $cond['value'];
            }

            // Search
            if ($this->searchTerm && $this->searchFields) {
                $searchParts = [];
                foreach ($this->searchFields as $field) {
                    $searchParts[] = "$field LIKE ?";
                    $params[] = '%' . $this->searchTerm . '%';
                }
                $searchClause = '(' . implode(' OR ', $searchParts) . ')';
                $prefix = !empty($whereParts) ? ' AND ' : '';
                $whereParts[] = $prefix . $searchClause;
            }

            if (!empty($whereParts)) {
                $sql .= " WHERE " . implode('', $whereParts);
            }

            // Order
            if ($this->sortKey) {
                $sql .= " ORDER BY {$this->sortKey} {$this->sortOrder}";
            }

            // Pagination
            $offset = ($this->page - 1) * $this->pageSize;
            $sql .= " LIMIT $offset, $this->pageSize";

            $stmt = $conn->prepare($sql);
            if (!$stmt) die("Prepare failed: " . $conn->error);

            if (!empty($params)) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            // Total count
            $totalResult = $conn->query("SELECT FOUND_ROWS() as total")->fetch_assoc();
            $conn->close();

            return [
                'data' => $data,
                'pagination' => [
                    'current_page' => $this->page,
                    'page_size' => $this->pageSize,
                    'total_items' => (int)$totalResult['total'],
                    'total_pages' => (int)ceil($totalResult['total'] / $this->pageSize),
                ]
            ];
        }

        public function get() {
            $this->limit = $this->limit ?? $this->pageSize;
            $this->page = 1;
            $this->pageSize = $this->limit;
            return $this->getWithPagination()['data'];
        }

        public function first() {
            $this->limit = 1;
            $results = $this->get();
            return $results[0] ?? null;
        }
    }


    // class QueryBuilder {
    //     private $table;
    //     private $conditions = [];
    //     private $limit = null;
    //     private $columns = ['*'];

    //     public function __construct($table) {
    //         $this->table = $table;
    //     }
        
    //     public function select(...$columns) {
    //         if (!empty($columns)) {
    //             $this->columns = $columns;
    //         }
    //         return $this;
    //     }


    //     public function where($field, $operatorOrValue, $value = null, $boolean = 'AND') {
    //         if ($value === null) {
    //             $value = $operatorOrValue;
    //             $operator = '=';
    //         } else {
    //             $operator = $operatorOrValue;
    //         }

    //         $this->conditions[] = [
    //             'boolean' => strtoupper($boolean),
    //             'field' => $field,
    //             'operator' => $operator,
    //             'value' => $value
    //         ];

    //         return $this;
    //     }

    //     public function orWhere($field, $operatorOrValue, $value = null) {
    //         return $this->where($field, $operatorOrValue, $value, 'OR');
    //     }

    //     public function limit($number) {
    //         $this->limit = (int)$number;
    //         return $this;
    //     }

    //     public function get() {
    //         $db = new Database();
    //         $conn = $db->connect();

    //         $sql = "SELECT " . implode(', ', $this->columns) . " FROM " . $this->table;
    //         $params = [];
    //         $whereClause = '';

    //         if (!empty($this->conditions)) {
    //             $parts = [];
    //             foreach ($this->conditions as $index => $cond) {
    //                 $prefix = $index === 0 ? '' : ' ' . $cond['boolean'] . ' ';
    //                 $parts[] = $prefix . "{$cond['field']} {$cond['operator']} ?";
    //                 $params[] = $cond['value'];
    //             }
    //             $whereClause = " WHERE " . implode('', $parts);
    //         }

    //         $sql .= $whereClause;

    //         if ($this->limit !== null) {
    //             $sql .= " LIMIT " . $this->limit;
    //         }

    //         $stmt = $conn->prepare($sql);
    //         if (!$stmt) die("Prepare failed: " . $conn->error);

    //         if (!empty($params)) {
    //             $types = str_repeat('s', count($params));
    //             $stmt->bind_param($types, ...$params);
    //         }

    //         $stmt->execute();
    //         $result = $stmt->get_result();

    //         $rows = [];
    //         while ($row = $result->fetch_assoc()) {
    //             $rows[] = $row;
    //         }

    //         $stmt->close();
    //         $conn->close();

    //         return $rows;
    //     }

    //     public function first() {
    //         $this->limit = 1;
    //         $results = $this->get();
    //         return $results[0] ?? null;
    //     }
    // }

?>
