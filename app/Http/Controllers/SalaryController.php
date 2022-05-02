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
		// return 'ad';
		return view('salary/pdf');
	}
	
	public function indexData()
	{

		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);


		// $query = " SELECT ID,姓名,本薪,年,月 FROM 薪資紀錄表 WHERE 姓名='馬克'";
		$query = " SELECT ID,姓名,本薪,年,月 FROM 薪資紀錄表 WHERE 年=2022 AND 月=4";

		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);

		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);

		$keys = ['id', 'name', 'basic', 'y', 'm'];
		$json = "";


		if(count($arr)==0)
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

		// return $sql;

		$sql = mb_convert_encoding($sql, "BIG5", "UTF-8");
		// echo $sql;
		// return;

		try {
			$statement = $db->prepare($sql);
			$statement->execute();
		} catch (PDOException $err) {
			print_r($err->getMessage());
		}

		// return $query;

	}

	public function update()
	{
		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);

		$obj = json_decode(file_get_contents('php://input'));
		$id = $obj->id;
		$basic = $obj->basic;

		$sql = " UPDATE 薪資紀錄表 SET 本薪='$basic' WHERE ID=$id";


		$sql = mb_convert_encoding($sql, "BIG5", "UTF-8");
		// echo $sql;
		// return;

		try {
			$statement = $db->prepare($sql);
			$statement->execute();
		} catch (PDOException $err) {
			print_r($err->getMessage());
		}

		// return $query;

	}

	// 轉薪資
	public function transOLD()
	{
		$rows = $this->getEmpBasic();
		return $rows[0]['gname'];
	}
	// 員工基本資料
	public function trans()
	{
		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);
		$query = " SELECT 姓名 as ename, 本薪 as basic FROM 員工基本資料 WHERE 離職日 IS NULL AND 姓名 <> 'LE'";
		// return $query;
		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);
		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);
		// $name = urlencode($arr[0]['gname']);
	
		foreach($arr as $emp){
			$name = $emp['ename'];
			$name = mb_convert_encoding($name,  "UTF-8","BIG5");
			$this->insert($name,$emp['basic']);
		}
		
	
		
	}

	public function insert($name,$basic)
	{
		// var_dump(implode($this->getEmpBasic()));
		// foreach($this->getEmpBasic() as $row){
		// 	echo $row;
		// }
		// print_r($this->getEmpBasic());
		// return $this->getEmpBasic();
		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);

		$obj = json_decode(file_get_contents('php://input'));
		
		// $basic = '35400';
		// $name = $name;
		// return $basic;
		$y = $obj->y;
		$m = $obj->m;
		

		$sql = " INSERT INTO 薪資紀錄表 (年,月,姓名,本薪) VALUES ($y,$m,'$name',$basic)";
		// $sql = " INSERT INTO 薪資紀錄表 ";
		// return $sql;

		$sql = mb_convert_encoding($sql, "BIG5", "UTF-8");
		// echo $sql;
		// return;

		try {
			$statement = $db->prepare($sql);
			$statement->execute();
		} catch (PDOException $err) {
			print_r($err->getMessage());
		}

		// return $query;

	}
}
