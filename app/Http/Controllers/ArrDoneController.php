<?php

namespace App\Http\Controllers;

class ArrDoneController extends Controller
{
	
	
	public function getData()
	{
		$connectionString = "odbc:master";
		$db = new \PDO($connectionString);	

		$query = " SELECT top 100  排程單號,工作人員編號 FROM 排程完工表";
		$query = mb_convert_encoding($query, "BIG5", "UTF-8");
		$rs = $db->query($query);		

		$arr = $rs->fetchAll(\PDO::FETCH_ASSOC);
		// print_r($arr);
		// return;
		$keys = ['id', 'workerID'];
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

	
}
