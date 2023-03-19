<?php

// print headers for JSON
header( 'Content-Type: application/json' );

$action_check = file_get_contents( 'action_check.json' );
$action_check = json_decode( $action_check, true );

if ( $_GET['action' === 'check'] ) {
	echo json_encode( $action_check );
}



die();
/*
if ( $_REQUEST['action'] == 'check' ) {
	$oa = new MW_OAuth ( 'wikishootme' , 'wikidata' , 'wikidata' ) ;
	$res = $oa->getConsumerRights() ;
	$res = json_decode( $res, true );
	$res = $res['query']['userinfo'];
	$res['rights'] = array_flip( $res['rights'] );
	$res['groups'] = array_flip( $res['groups'] );
	$res['status'] = 'OK';
	$res = json_encode( $res );
	echo $res;
	exit(0);
}*/


/*
{
	"status": "OK",
	"result": {
	  "batchcomplete": "",
	  "query": {
		"userinfo": {
		  "id": 11835224,
		  "name": "Natmacira",
		  "groups": [
			"*",
			"user",
			"autoconfirmed"
		  ],
		  "rights": [
			"read",
			"edit",
			"createpage",
			"createtalk",
			"writeapi",
			"translate",
			"abusefilter-view",
			"abusefilter-log",
			"flow-hide",
			"item-term",
			"property-term",
			"item-merge",
			"item-redirect",
			"property-create",
			"mediainfo-term",
			"upload",
			"reupload-own",
			"move-categorypages",
			"minoredit",
			"purge",
			"applychangetags",
			"imagelabel-review",
			"move",
			"autoconfirmed",
			"editsemiprotected",
			"skipcaptcha",
			"abusefilter-log-detail",
			"flow-edit-post"
		  ]
		}
	  }
	}
  }
  */
