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






	public function indexData()
	{
		
		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);
		
		$query = " SELECT top 500 ID,姓名,本薪,年,月 FROM 薪資紀錄表";
		
		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);

		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);
		
		$keys = ['id', 'name', 'basic', 'y', 'm'];
		$json = "";

		for ($i = 0; $i < count($arr); $i++) {
			$j = 0;
			foreach ($arr[$i] as $key => $value) {
				// 字串後面有空白導致無法正確輸出 json 格式, 加上 trim            
				$newarr[urlencode($keys[$j])] = urlencode(trim($value));
				$j++;
			}
			// 原始日期 2022-01-05 00:00:00 將時分秒去掉    
			// $newarr["bonusDate"] = substr( $newarr["bonusDate"] , 0 , 10 );
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
}
