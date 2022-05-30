<?php

namespace App\Http\Controllers;

class ExpenseController extends Controller
{




	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('expense/index');
	}

	public function data()
	{
		$connectionString = "odbc:master";
		$db = new \PDO($connectionString);

		$name = isset($_GET["name"]) ? urlencode($_GET["name"]) : "";
		$name = urldecode($name);

		$where = "";

		if ($name) {
			if ($where != "") {
				$where .= " AND ";
			}
			$where .= "品名 LIKE '%$name%' ";
		}

		if ($where != "")
			$where = " where " . $where;

		

		$query = " SELECT top 35000 ID,日期,品名 FROM 費用表 ";

		// $query = " SELECT top 5 ID,日期,品名 FROM 費用表 WHERE ID=5371 ";
		// $query = " SELECT 品名 FROM 費用表 WHERE ID=5371 ";

		if ($where) {
			$query .= $where;
		}

		// return $name;
		// return $query;

		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);
		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);

		$keys = ['id', 'date', 'name'];
		$json = "";


		if (count($arr) == 0)
			return;

		for ($i = 0; $i < count($arr); $i++) {
			$j = 0;
			foreach ($arr[$i] as $key => $value) {
				// 字串後面有空白導致無法正確輸出 json 格式, 加上 trim            
				$value = str_replace('"','\"',$value);
				$newarr[urlencode($keys[$j])] = urlencode(trim($value));
				$j++;

				// $mystring = 'abc';
				// $findme   = 'a';
				// $pos = strpos($value, '"');
			
				// echo $value."<br>";
				// return $pos;
			}

			$rows[$i] = $newarr;
		}
		// print_r($arr);
		// return;
		// return $arr[0]['品名'];
		// return $rows[0];
		// array to json
		$json = json_encode($rows);

		// 再用urldecode把資料轉回成中文格式
		$json = urldecode($json);

		return response($json, 200)
			->header('Content-Type', 'text/html;charset=big5');
	}
}
