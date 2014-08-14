$(document).ready(function(){
	//5分ごとに呼び出す
	setInterval(function()
	{
		reload();

	},600000);

	$("#reload").click(function() {
		  reload();
	});
	
});

function reload(){

	$.ajax({

		type: "POST",
		url: 'home/reload',
		data: {
			"last": $('#last-update').text()
		},
		success: function( res )
		{
            //受け取ったjsonを配列に
            var datas = eval("(" + res + ")");
            //最終更新
            $('#last-update').text(datas['last_update']);
            if(!datas["tweet"])
             	return 0;
            //追加するliの作成
            Object.keys(datas["tweet"]).forEach(function(key){
              	//liの作成	                    	
                var li_content = createNewLi(datas["tweet"][key],datas['user_id'],datas['base_url']);
                   	$("#timeline").prepend($(li_content));
                   })
             },
        error: function(res){
           	console.log("error");
        }
     })

}

function createNewLi(item,user_id,base_url){
	var $li_content = $('<li>');
	$li_content.append($('<p>').text("投稿者:"+item['username']));
	$li_content.append($('<p>').text(item['content']));
	$li_content.append($('<p>').text("投稿日:"+item['created_at']));
	if(item['image_path'] != null)
		$li_content.append($('<img />').attr({ 
		      src: base_url+"assets/img"+item['image_path'],
		      alt: "画像"
		    }));
	if(item['user_id'] == user_id){
		var $delete_link = $('<a>').attr({ 
		      href: base_url +"/home/delete/"+ item['id']
		    });
		$delete_link.text("削除する");
		$li_content.append($delete_link);
	}
	return $li_content;
}

