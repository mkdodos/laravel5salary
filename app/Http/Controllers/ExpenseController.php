<?php namespace App\Http\Controllers;

class ExpenseController extends Controller {

	


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

		

		$query = " SELECT top 5 ID,日期,品名 FROM 費用表 ";

		if ($where) {
			$query .= $where;
		}

		// return $query;

		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);
		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);

		$keys = [ 'id','date','name'];
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

		return response($json, 200)
			->header('Content-Type', 'text/html;charset=big5');
		
	}


}
