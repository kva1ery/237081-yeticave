<?php

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 * @param $conn mysqli  Ресурс соединения
 * @param $sql  string  SQL запрос с плейсхолдерами вместо значений
 * @param $data array   Данные для вставки на место плейсхолдеров
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($conn, $sql, $data = []) {
    $stmt = mysqli_prepare($conn, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }
    return $stmt;
}

/**
 * Выполянет запрос на выборку данных на основе SQL запроса и переданных данных
 * @param $conn mysqli Ресурс соединения
 * @param $sql  string SQL запрос с плейсхолдерами вместо значений
 * @param $data array  Данные для вставки на место плейсхолдеров
 * @return array данные из БД
 */
function db_fetch_data($conn, $sql, $data = []) {
    $result = [];
    $stmt = db_get_prepare_stmt($conn, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
};

/**
 * Выполянет запрос на вставку данных на основе SQL запроса и переданных данных
 * @param $conn mysqli Ресурс соединения
 * @param $sql  string SQL запрос с плейсхолдерами вместо значений
 * @param $data array  Данные для вставки на место плейсхолдеров
 * @return int id вставленной записи
 */
function db_insert_data($conn, $sql, $data = []) {
  $stmt = db_get_prepare_stmt($conn, $sql, $data);
  $result = mysqli_stmt_execute($stmt);
  if ($result) {
      $result = mysqli_insert_id($conn);
  }
  return $result;
}
