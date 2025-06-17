<?php
    class MySQLiDataProcessor {
        protected mysqli $conn;
        protected string $table;
        protected array $filters = [];
        protected string $filterLogic = 'AND';
        protected ?string $sortKey = null;
        protected string $sortOrder = 'asc';
        protected int $page = 1;
        protected int $pageSize = 10;
        protected ?string $searchTerm = null;
        protected array $searchFields = [];

        public function __construct(mysqli $conn, string $table) {
            $this->conn = $conn;
            $this->table = $table;
        }

        public function addFilter(string $column, $value): self {
            $this->filters[] = ['column' => $column, 'value' => $value];
            return $this;
        }

        public function setFilterLogic(string $logic): self {
            $logic = strtoupper($logic);
            if (!in_array($logic, ['AND', 'OR'])) {
                throw new InvalidArgumentException("Filter logic must be 'AND' or 'OR'");
            }
            $this->filterLogic = $logic;
            return $this;
        }

        public function setSort(string $column, string $order = 'asc'): self {
            $this->sortKey = $column;
            $this->sortOrder = strtolower($order) === 'desc' ? 'DESC' : 'ASC';
            return $this;
        }

        public function setPagination(int $page, int $pageSize): self {
            $this->page = max(1, $page);
            $this->pageSize = max(1, $pageSize);
            return $this;
        }

        public function setSearch(string $term, array $fields): self {
            $this->searchTerm = $term;
            $this->searchFields = $fields;
            return $this;
        }

        public function getResult(): array {
            $conditions = [];
            $params = [];
            $types = '';

            // Filters
            foreach ($this->filters as $filter) {
                $conditions[] = "`{$filter['column']}` = ?";
                $params[] = $filter['value'];
                $types .= 's'; // assuming string; adjust type detection as needed
            }

            // Search
            if ($this->searchTerm !== null && !empty($this->searchFields)) {
                $searchSubConditions = [];
                foreach ($this->searchFields as $field) {
                    $searchSubConditions[] = "`$field` LIKE ?";
                    $params[] = '%' . $this->searchTerm . '%';
                    $types .= 's';
                }
                $conditions[] = '(' . implode(' OR ', $searchSubConditions) . ')';
            }

            $whereClause = '';
            if (!empty($conditions)) {
                $whereClause = 'WHERE ' . implode(" {$this->filterLogic} ", $conditions);
            }

            // Sorting
            $orderClause = '';
            if ($this->sortKey !== null) {
                $orderClause = "ORDER BY `{$this->sortKey}` {$this->sortOrder}";
            }

            // Pagination
            $offset = ($this->page - 1) * $this->pageSize;
            $limitClause = "LIMIT {$offset}, {$this->pageSize}";

            // Total count query
            $countQuery = "SELECT COUNT(*) as total FROM `{$this->table}` $whereClause";
            $stmt = $this->conn->prepare($countQuery);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $countResult = $stmt->get_result()->fetch_assoc();
            $totalItems = (int) $countResult['total'];
            $stmt->close();

            // Main data query
            $query = "SELECT * FROM `{$this->table}` $whereClause $orderClause $limitClause";
            $stmt = $this->conn->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return [
                'data' => $data,
                'pagination' => [
                    'current_page' => $this->page,
                    'page_size' => $this->pageSize,
                    'total_pages' => (int)ceil($totalItems / $this->pageSize),
                    'total_items' => $totalItems,
                ],
            ];
        }
    }
