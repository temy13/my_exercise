$(document).ready(function(){
	//10秒ごとに呼び出す
	  setInterval(function()
	  {
			$.ajax({

				 	type: "POST",
	                url: 'home/reload',
	      			data: {
				                "last": $('#last-update').text()
				            },
	                success: function( res )
	                {
	                	var datas = eval("(" + res + ")");
	                	$('#last-update').text(datas['last_update']);
	                	console.log(datas['last_update']);
	                	if(!datas["tweet"])
	                		return 0;

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

		},10000);
	
});


function createNewLi(item,user_id,base_url){
	var li_content = "<li>";
		li_content += "<p>投稿者:"+item['username'] + "</p>";
		li_content += "<p>"+item['content']  + "</p>";
		li_content += "<p>投稿日:"+item['created_at']  + "</p>";
		if(item['image_path'] != null)
			li_content += "<img alt='画像' src='"+
						base_url+"assets/img"+item['image_path']
						+ "'>";
		if(item['user_id'] == user_id)
			li_content +="<p><a href='" + 
						base_url +"/home/delete/"+ item['id']
						+ "'>削除する</a></p>"  		
		li_content += "</li>";
	return li_content;
}

