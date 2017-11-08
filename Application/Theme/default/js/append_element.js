$(function(){
	var MaxInputs = 4; //maximum input boxes allowed
    var InputsWrapper = $("#InputsWrapper"); //Input boxes wrapper ID
    var AddButton = $("#AddMoreFileBox"); //Add button ID

    var x = InputsWrapper.length; //initlal text box count
    var FieldCount = 1; //to keep track of text box added

    $(AddButton).click(function(e){
        if (x <= MaxInputs) //max input box allowed
        {
            FieldCount++; //text box added increment
            //add input box
            $(InputsWrapper).append('<div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">时间：</label></div><div class="weui_cell_bd weui_cell_primary"><input name="service_start" type="text" class="weui_input" /></div></div> <div class="weui_cell cell_box"><div class="weui_cell_hd">                    <label class="weui_label">></label>                </div>                <div class="weui_cell_bd weui_cell_primary">                    <input name="service_end" type="text" class="weui_input" />                </div>            </div>            <div class="weui_cell cell_box">                <div class="weui_cell_hd">                    <label class="weui_label">部门：</label>                </div>                <div class="weui_cell_bd weui_cell_primary">                    <input name="height" type="text" class="weui_input" />                </div>            </div>            <div class="weui_cell cell_box">                <div class="weui_cell_hd">                    <label class="weui_label">职务：</label>                </div>                <div class="weui_cell_bd weui_cell_primary">                    <input name="weight" type="text" class="weui_input" />                </div>            </div>');
            x++; //text box increment
        }
        return false;
    });

    var InputsWrapper_edu = $("#InputsWrapper_edu"); //Input boxes wrapper ID

    var x = InputsWrapper_edu.length; //initlal text box count
    var FieldCount = 1; //to keep track of text box added

    $(".add_edu_row").click(function(e){
        if (x <= MaxInputs) //max input box allowed
        {
            FieldCount++; //text box added increment
            //add input box
            $(InputsWrapper_edu).append('<div class="weui_cell cell_box"><div class="weui_cell_hd"><label class="weui_label">时间：</label></div><div class="weui_cell_bd weui_cell_primary"><input name="service_start" type="text" class="weui_input" /></div></div> <div class="weui_cell cell_box"><div class="weui_cell_hd">                    <label class="weui_label">></label>                </div>                <div class="weui_cell_bd weui_cell_primary">                    <input name="service_end" type="text" class="weui_input" />                </div>            </div>            <div class="weui_cell cell_box">                <div class="weui_cell_hd">                    <label class="weui_label">部门：</label>                </div>                <div class="weui_cell_bd weui_cell_primary">                    <input name="height" type="text" class="weui_input" />                </div>            </div>            <div class="weui_cell cell_box">                <div class="weui_cell_hd">                    <label class="weui_label">职务：</label>                </div>                <div class="weui_cell_bd weui_cell_primary">                    <input name="weight" type="text" class="weui_input" />                </div>            </div>');
            x++; //text box increment
        }
        return false;
    });
	var calendar = new LCalendar();
    calendar.init({
        'trigger': '#start_date', //标签id
        'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
        'minDate': (new Date().getFullYear() - 3) + '-' + 1 + '-' + 1, //最小日期
        'maxDate': (new Date().getFullYear() + 3) + '-' + 12 + '-' + 31 //最大日期
    });
});