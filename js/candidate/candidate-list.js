$(function(){

	$.ajax({
		url:"./serverScript/fetch_candidate_list.php",
        dataType:"json",
        success:function(data){
        			var list = "";
        			$.each(data, function(index){
        				list = "<div class=\"mdl-card mdl-shadow--2dp mdl-card--horizontal\"> \
        							<div class=\"mdl-card__media\"> \
        								<img src=\"./img/candidate/"+data[index].photo+"\"alt=\"img\"> \
			                     	</div> \
			                        <div class=\"mdl-card__title\"> \
			                          <h2 class=\"mdl-card__title-text\">"+data[index].name+"</h2> \
			                        </div> \
			                        <div class=\"mdl-card__supporting-text\"> \
			                            <ul class=\"qualification\"> \
			                                <li>Degree : "+data[index].degree+"</li>  \
			                                <li>Experience: "+data[index].experience+" yr</li> \
			                            </ul> \
			                        </div> \
			                        <div class=\"mdl-card__actions mdl-card--border\"> \
			                          <a href=details.php?id="+data[index].c_id+" class=\"more-info\">More info</a> \
			                        </div> \
			                        <div class=\"mdl-card__menu\"> \
			                          <h2>#"+data[index].c_rank+"</h2> \
			                        </div> \
			                    </div>";
       					$("#candidate-list").append(list);
       				});
       			}
	});
});