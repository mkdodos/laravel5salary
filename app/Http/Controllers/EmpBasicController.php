<?php

namespace App\Http\Controllers;

class EmpBasicController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

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
		return view('home');
	}

	public function basic()
	{
		// $rows = json_decode($this->basicData(),true);
		// $rows = $this->basicDataJSON();
		// return $rows;
		// $rows ="abc";
		return view('emp/basic');
	}

	
	
	
	public function basicData()
	{
		$connectionString = "odbc:salary";
		$db = new \PDO($connectionString);


		// $query = " update 測 set 姓名='宜君'";
		// $query = mb_convert_encoding($query, "BIG5", "UTF-8");

		$query = " SELECT 姓名,本薪 FROM 員工基本資料 WHERE 離職日 IS NULL AND 姓名 <> 'LE'";
		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);

		// 取得資料陣列
		// $array = $rs->fetchAll();
		// return ;

		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);
		// print_r($arr);
		// return;
		$keys = ['name', 'basic'];
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

	// 機台工作人員
	public function worker()
	{		
		return view('emp/worker');
	}

	// 機台工作人員資料
	public function workerData()
	{				
		$db = new \PDO("odbc:salary");
		$keys = ['id', 'name'];
		$query = " SELECT 工作人員編號,姓名 FROM 員工基本資料 WHERE 離職日 IS NULL ";
		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);
		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);		
		
		$json = "";		
		for ($i = 0; $i < count($arr); $i++) {
			$j = 0;
			foreach ($arr[$i] as $key => $value) {			        
				$newarr[urlencode($keys[$j])] = urlencode(trim($value));
				$j++;
			}		
			$rows[$i] = $newarr;
		}
		
		$json = json_encode($rows);
		
		$json = urldecode($json);	

		return response($json, 200)
			->header('Content-Type', 'text/html;charset=big5');		
	}

	public function login() 
	{
		$db = new \PDO("odbc:salary");
		$obj = json_decode(file_get_contents('php://input'));
		$name = $obj->name;
		$pwd = $obj->pwd;
		$query = " SELECT * FROM 員工基本資料 WHERE 姓名='$name' 
		AND 登入密碼='$pwd' ";
		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);
		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);	

		

		return count($arr);
		
		
		return $obj->name;
		return $obj->pwd;
	}
}
