$(function(){
	var MaxInputs = 4; //maximum input boxes allowed
    var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
    var AddButton = $("#AddMoreFileBox"); //Add button ID

    var x = InputsWrapper.children().length; //initlal text box count
    var FieldCount = 1; //to keep track of text box added
    console.log(x);
    $(AddButton).click(function(e){
        if (x <= MaxInputs) //max input box allowed
        {
            FieldCount++; //text box added increment
            //add input box
            $(InputsWrapper).append('<div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">时间：</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_service_start['+x+']" id="new_service_start_'+x+'" type="text" readonly=true class="weui_input calendar_box" /></div></div> <div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_service_end['+x+']" readonly=true id="new_service_end_'+x+'" type="text" class="weui_input calendar_box" /></div></div><div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">部门：</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_department['+x+']" type="text" class="weui_input" /></div></div><div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">职务：</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_position['+x+']" type="text" class="weui_input" /></div></div>');
            x++;
            get_datetimepicker();
        }
        return false;
    });

    var InputsWrapper_edu = $("#InputsWrapper_edu"); //Input boxes wrapper ID

    var x = 1; //initlal text box count
    var FieldCount = 1; //to keep track of text box added
	var AddButton = $("#AddMoreEduBox")
    $(AddButton).click(function(e){
        if (x <= MaxInputs) //max input box allowed
        {
            FieldCount++; //text box added increment
            //add input box
            $(InputsWrapper_edu).append('<div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">学习时间：</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_edu_service_start['+x+']" id="new_edu_service_start_'+x+'" type="text" readonly=true class="weui_input calendar_box" /></div></div> <div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_edu_service_end['+x+']" readonly=true id="new_edu_service_end_'+x+'" type="text" class="weui_input calendar_box" /></div></div><div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">学校：</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_school['+x+']" type="text" class="weui_input" /></div></div><div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">学位：</label></div><div class="weui_cell_bd weui_cell_primary"><select name="new_degree['+x+']" class="weui_input"><option value="小学">小学</option><option value="初中">初中</option><option value="高中">高中</option><option value="大学专科">大学专科</option><option value="大学本科">大学本科</option><option value="硕士">硕士</option><option value="博士">博士</option></select></div></div>');
            x++; //text box increment
            get_datetimepicker();
        }
        return false;
    });
    
});

function get_datetimepicker(){
    var nowData = new Date();
    nowData.setDate(nowData.getDate()+1);

    var opt= { 
        theme:'ios', //设置显示主题 
        mode:'scroller', //设置日期选择方式，这里用滚动
        display:'bottom', //设置控件出现方式及样式
        preset : 'date', //日期:年 月 日 时 分
        // minDate: nowData, 
        maxDate: nowData,
        dateFormat: 'yy-mm', // 日期格式
        dateOrder: 'yymm', //面板中日期排列格式
        stepMinute: 5, //设置分钟步长
        yearText:'年', 
        monthText:'月',
        dayText:'日',
        // hourText:'时',
        // minuteText:'分',
        lang:'zh' //设置控件语言};
    };
    $('.calendar_box').mobiscroll(opt);
}