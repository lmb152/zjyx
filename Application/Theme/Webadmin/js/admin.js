(function($){
    $(".delete").click(function(e) {
        e.preventDefault();
        $url=$(this).attr('href');
        $.ajax( {  
            url:$url,
            type:'get',  
            success:function(rs) {  
                console.log(rs);
                if(rs=='1'){ 
                    alert("删除成功！");  
                    window.location.reload();  
                }else{  
                    alert("删除失败"); 
                }  
             },  
             error : function() {    
                  alert("异常！");  
             }  
        });
    });
    $(".passed").click(function(e) {
        e.preventDefault();
        $url=$(this).attr('href');
        $.ajax( {  
            url:$url,
            type:'get',  
            success:function(rs) {  
                console.log(rs);
                if(rs=='1'){ 
                    alert("审核成功！");  
                    window.location.reload();  
                }else{  
                    alert("审核失败"); 
                }  
             },  
             error : function() {    
                  alert("异常！");  
             }  
        });
    });
    $('.show_report').click(function(){
        var pdf=$(this).attr('rel-pdf');
        if(pdf){
            var url='/Public/uploads/'+pdf;
            window.open (url,'newwindow','height=700px,width=1000px,top=0,left=200px,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no'); 
        }else{
            alert('暂无年度报告,请添加');
        }
    });
})(jQuery);