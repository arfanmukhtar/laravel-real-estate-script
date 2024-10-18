<?php 
    // $purcahse_Code = "faa1b084-1eb4-4193-83ed-1017c813c3bb";
    $purcahse_Code = !empty($_REQUEST["purchase_code"]) ? $_REQUEST["purchase_code"] : "";
    if($purcahse_Code == "") { 
        echo "failed";
        exit;
    } 
    $authorization = "Authorization: Bearer kdDx3CR40AdO2F5J5FxrHHisrro4Kubx";
    $url = "https://api.envato.com/v2/market/author/sale?code=$purcahse_Code";
    

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        $authorization
    ));
    $data = curl_exec($ch);
    $data = json_decode($data); 
    $dataI = array(
        "amount" => $data->amount,
        "sold_at" => $data->sold_at,
        "item_id" => $data->item->id,
        "purchase_count" => $data->purchase_count,
        "buyer" => $data->buyer
    );

    curl_close($ch);

    if($data->amount > 0) { 
        echo "success"; exit;
    }
    echo "failed";exit;

    // echo "<pre>"; print_r( $data);
    echo "<pre>"; print_r( $dataI); exit;
    $info = curl_getinfo($ch);
   
    // close curl resource to free up system resources
    curl_close($ch);

?>