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

		
		// 問題 id 42397 , 37603, 36760 不知什麼問題, 內容重新剪下貼上就好了
		// 可能是內容有被 enter 換成二行
		$query = " SELECT top 50000 費用表.ID,日期,品名,金額,進貨數量,廠商名稱 FROM 費用表 LEFT JOIN 廠商資料表 ON 廠商資料表.廠商編號 = 費用表.廠商編號";
		// $query = " SELECT top 50 費用表.ID, 日期, 費用表.品名, 費用表.金額, 進貨數量 FROM 廠商資料表 INNER JOIN 費用表 ON 廠商資料表.廠商編號 = 費用表.廠商編號
		// ORDER BY 費用表.ID DESC
		// ";
		$keys = ['id', 'date', 'name','price','qty','supp'];		

		if ($where) {
			$query .= $where;
		}

		$query.= " order by 費用表.ID desc";
	

		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);
		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);

		
		$json = "";


		if (count($arr) == 0)
			return;

		for ($i = 0; $i < count($arr); $i++) {
			$j = 0;
			foreach ($arr[$i] as $key => $value) {				          
				// json 字串用""括起,如果內容有"符號,會出問題
        // 要加 \ 跳脫
				$value = str_replace('"','\"',$value);
				// 字串後面有空白導致無法正確輸出 json 格式, 加上 trim  				
				$newarr[urlencode($keys[$j])] = urlencode(trim($value));
				$j++;			
			}

			$rows[$i] = $newarr;
		}
		
		$json = json_encode($rows);

		// 再用urldecode把資料轉回成中文格式
		$json = urldecode($json);

		return response($json, 200)
			->header('Content-Type', 'text/html;charset=big5');
	}
}
