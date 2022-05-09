<?php

namespace App\Http\Controllers;

class SalaryController extends Controller
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('salary/index');
	}

	public function pdf()
	{
		return view('salary/pdf');
	}

	public function chart()
	{
		return view('salary/chart');
	}

	public function indexData()
	{

		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);


		// 依前端傳來參數組合查詢條件
		$y = isset($_GET["y"]) ? $_GET["y"] : "";
		$m = isset($_GET["m"]) ? $_GET["m"] : "";
		$name = isset($_GET["name"]) ? urlencode($_GET["name"]) : "";
		$name = urldecode($name);

		$where = "";
		if ($y)
			$where = " 年 = $y ";

		if ($m) {
			if ($where != "") {
				$where .= " AND ";
			}
			$where .= "月 = $m ";
		}

		if ($name) {
			if ($where != "") {
				$where .= " AND ";
			}
			$where .= "姓名 ='$name' ";
		}

		if ($where != "")
			$where = " where " . $where;


		// return $where;
		// $query = " SELECT ID,姓名,本薪,年,月 FROM 薪資紀錄表 WHERE 姓名='馬克'";
		// $query = " SELECT ID,姓名,本薪,年,月 FROM 薪資紀錄表 WHERE 年=2022 AND 月=4";
		$query = " SELECT ID,姓名,年,月,本薪,職務加給,技術加給 FROM 薪資紀錄表 ";

		if ($where) {
			$query .= $where;
		}

		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);

		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);

		$keys = ['id', 'name', 'y', 'm','basic', 'job','tech' ];
		$json = "";


		if (count($arr) == 0)
			return;

		for ($i = 0; $i < count($arr); $i++) {
			$j = 0;
			foreach ($arr[$i] as $key => $value) {
				// 字串後面有空白導致無法正確輸出 json 格式, 加上 trim            
				$newarr[urlencode($keys[$j])] = urlencode(trim($value));
				$j++;
			}

			$rows[$i] = $newarr;
		}


		// array to json
		$json = json_encode($rows);

		// 再用urldecode把資料轉回成中文格式
		$json = urldecode($json);
		// return $json;

		return response($json, 200)
			->header('Content-Type', 'text/html;charset=big5');
	}

	public function destory()
	{
		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);

		$obj = json_decode(file_get_contents('php://input'));
		$id = $obj->id;

		$sql = " DELETE FROM 薪資紀錄表 WHERE ID=$id";		

		$sql = mb_convert_encoding($sql, "BIG5", "UTF-8");
		
		try {
			$statement = $db->prepare($sql);
			$statement->execute();
		} catch (PDOException $err) {
			print_r($err->getMessage());
		}	

	}

	public function update()
	{
		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);

		$obj = json_decode(file_get_contents('php://input'));
		$id = $obj->id;
		$basic = $obj->basic;
		$job = $obj->job;
		$tech = $obj->tech;

		$sql = " UPDATE 薪資紀錄表 SET 本薪='$basic',職務加給='$job',技術加給='$tech' WHERE ID=$id";

		$sql = mb_convert_encoding($sql, "BIG5", "UTF-8");
		
		try {
			$statement = $db->prepare($sql);
			$statement->execute();
		} catch (PDOException $err) {
			print_r($err->getMessage());
		}		

	}

	
	// 轉薪資
	public function trans()
	{
		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);
		$query = " SELECT 姓名 as ename, 本薪 as basic FROM 員工基本資料 WHERE 離職日 IS NULL AND 姓名 <> 'LE'";
		
		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);
		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);		

		foreach ($arr as $emp) {
			$name = $emp['ename'];
			$name = mb_convert_encoding($name,  "UTF-8", "BIG5");
			$this->insert($name, $emp['basic']);
		}
	}

	public function insert($name, $basic)
	{		
		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);

		$obj = json_decode(file_get_contents('php://input'));
		
		$y = $obj->y;
		$m = $obj->m;

		$sql = " INSERT INTO 薪資紀錄表 (年,月,姓名,本薪) VALUES ($y,$m,'$name',$basic)";		

		$sql = mb_convert_encoding($sql, "BIG5", "UTF-8");		

		try {
			$statement = $db->prepare($sql);
			$statement->execute();
		} catch (PDOException $err) {
			print_r($err->getMessage());
		}		

	}
}
