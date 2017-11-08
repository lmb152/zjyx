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
            var calendar = new LCalendar();
            var trigger='#new_service_start_'+x;
            console.log(trigger);
            calendar.init({
	            'trigger': trigger, //标签id
	            'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
	            'minDate': (new Date().getFullYear() - 3) + '-' + 1 + '-' + 1, //最小日期
	            'maxDate': (new Date().getFullYear() + 3) + '-' + 12 + '-' + 31 //最大日期
	        });
	        var calendar = new LCalendar();
	        var trigger='#new_service_end_'+x;
	        calendar.init({
	            'trigger': trigger, //标签id
	            'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
	            'minDate': (new Date().getFullYear() - 3) + '-' + 1 + '-' + 1, //最小日期
	            'maxDate': (new Date().getFullYear() + 3) + '-' + 12 + '-' + 31 //最大日期
	        });
	        x++;
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
            $(InputsWrapper_edu).append('<div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">时间：</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_edu_service_start['+x+']" id="new_edu_service_start_'+x+'" type="text" readonly=true class="weui_input calendar_box" /></div></div> <div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_edu_service_end['+x+']" readonly=true id="new_edu_service_end_'+x+'" type="text" class="weui_input calendar_box" /></div></div><div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">学校：</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_school['+x+']" type="text" class="weui_input" /></div></div><div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">学位：</label></div><div class="weui_cell_bd weui_cell_primary"><input name="new_degree['+x+']" type="text" class="weui_input" /></div></div>');
            var calendar = new LCalendar();
            var trigger='#new_edu_service_start_'+x;
            console.log(trigger);
            calendar.init({
	            'trigger': trigger, //标签id
	            'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
	            'minDate': (new Date().getFullYear() - 3) + '-' + 1 + '-' + 1, //最小日期
	            'maxDate': (new Date().getFullYear() + 3) + '-' + 12 + '-' + 31 //最大日期
	        });
	        var calendar = new LCalendar();
	        var trigger='#new_edu_service_end_'+x;
	        calendar.init({
	            'trigger': trigger, //标签id
	            'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
	            'minDate': (new Date().getFullYear() - 3) + '-' + 1 + '-' + 1, //最小日期
	            'maxDate': (new Date().getFullYear() + 3) + '-' + 12 + '-' + 31 //最大日期
	        });x++; //text box increment
        }
        return false;
    });
});