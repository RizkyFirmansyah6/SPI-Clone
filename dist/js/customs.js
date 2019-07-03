// deklarasi onclick TREE
$('#tt').tree({
	onClick: function(node){
		if(node.attributes != ''){loadCenter(node.attributes);}
	}
});
// load data ke div#center
function loadCenter(param){
	var target = "#center";
	$.ajax({
		url: the_url+"index.php/"+param, 
		type: "POST", 
		dataType: "html",
		beforeSend: function(){
			$(target).html('<div style="padding:5px; font-size:16px;"><i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;&nbsp;Loading . . . .</div>');
		},
		success: function(response){
			$(target).html(response);
			$.parser.parse(target);
		},
		error: function(){
			alert('error');
		},
	});
	return false;
}
