/*
量体数据
 */
/*****标题验证*****/
function beforeSubmit_caption(){
    if($("input[name = 'caption']").val() == '' || $("input[name = 'caption']").val() == null){
        alert("标题数据不能为空！");
        $("input[name = 'caption']").focus();
        return false;
        }
    if($("input[name = 'caption']").val().length>=20){
        alert('标题不能多于20个字符！');
        $("input[name = 'caption']").focus();
        return false;
        }
    //标题数据验证
    var reg_ch=/^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9_]){1,20}$/;//包含中文，英文和数字下划线验证
    var reg_eng=/^[a-zA-Z]*$/; //英文验证
    var reg_dig = /^\d{0,3}$/; //数字验证
    if(!reg_ch.test($("input[name = 'caption']").val())){
        alert('标题只能由中文、英文和数字和下划线组成！');
        $("input[name = 'caption']").focus();
        return false;
        }
}

function beforeSubmit_caption_p(){
    if ($("#caption").text() == null || $("#caption").text() == '') {
        alert('请选择数据后提交。');
        return false;
    }
    return true;
}
/*****量体暂存数据验证*****/
function beforeSubmit_temp(){
    var reg_ch=/^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9_]){1,20}$/;//包含中文，英文和数字下划线验证
    var reg_eng=/^[a-zA-Z]*$/; //英文验证
    var reg_dig = /^\d{0,3}$/; //数字验证
    //量体数据验证，不为空的情况下。暂存数据可以为空
    //肩宽shoulder
    if($("input[name = 'shoulder']").val()!=''){
        if(!reg_dig.test($("input[name = 'shoulder']").val()) || $("input[name = 'shoulder']").val()=='0'){
        alert('肩宽数据只能为3位以内数字！且不能为0！');
        $("input[name = 'shoulder']").focus();
        return false;
    }
    }
    //上臂围arm
    if($("input[name = 'arm']").val()!=''){
        if(!reg_dig.test($("input[name = 'arm']").val()) || $("input[name = 'arm']").val()=='0'){
        alert('上臂围数据只能为3位以内数字！且不能为0！');
        $("input[name = 'arm']").focus();
        return false;
    }
    }
    //肘围elbow
    if($("input[name = 'elbow']").val()!=''){
        if(!reg_dig.test($("input[name = 'elbow']").val()) || $("input[name = 'elbow']").val()=='0'){
        alert('肘围数据只能为3位以内数字！且不能为0！');
        $("input[name = 'elbow']").focus();
        return false;
    }
    }
    //腕围wrist
    if($("input[name = 'wrist']").val()!=''){
        if(!reg_dig.test($("input[name = 'wrist']").val()) || $("input[name = 'wrist']").val()=='0'){
        alert('腕围数据只能为3位以内数字！且不能为0！');
        $("input[name = 'wrist']").focus();
        return false;
    }
    }
    //袖长sleeve
    if($("input[name = 'sleeve']").val()!=''){
        if(!reg_dig.test($("input[name = 'sleeve']").val()) || $("input[name = 'sleeve']").val()=='0'){
        alert('袖长数据只能为3位以内数字！且不能为0！');
        $("input[name = 'sleeve']").focus();
        return false;
    }
    }
    //胸围chest
    if($("input[name = 'chest']").val()!=''){
        if(!reg_dig.test($("input[name = 'chest']").val()) || $("input[name = 'chest']").val()=='0'){
        alert('胸围数据只能为3位以内数字！且不能为0！');
        $("input[name = 'chest']").focus();
        return false;
    }
    }
    //腰围waist
    if($("input[name = 'waist']").val()!=''){
        if(!reg_dig.test($("input[name = 'waist']").val()) || $("input[name = 'waist']").val()=='0'){
        alert('腰围/小肚围数据只能为3位以内数字！且不能为0！');
        $("input[name = 'waist']").focus();
        return false;
    }
    }
    //后衣长clothes
    if($("input[name = 'clothes']").val()!=''){
        if(!reg_dig.test($("input[name = 'clothes']").val()) || $("input[name = 'clothes']").val()=='0'){
        alert('前衣长数据只能为3位以内数字！且不能为0！');
        $("input[name = 'clothes']").focus();
        return false;
    }
    }
    //臀围hip
    if($("input[name = 'hip']").val()!=''){
        if(!reg_dig.test($("input[name = 'hip']").val()) || $("input[name = 'hip']").val()=='0'){
        alert('后衣长数据只能为3位以内数字！且不能为0！');
        $("input[name = 'hip']").focus();
        return false;
    }
    }
    //上领围neck
    if($("input[name = 'neck']").val()!=''){
        if(!reg_dig.test($("input[name = 'neck']").val()) || $("input[name = 'neck']").val()=='0'){
        alert('上领围数据只能为3位以内数字！且不能为0！');
        $("input[name = 'neck']").focus();
        return false;
    }
    }

//如果没有错误，返回true
    return true;
}

/*****确认数据验证*****/
function beforeSubmit_confirm(){
    var reg_dig = /^\d{1,3}$/; //数字验证
    if(
        !reg_dig.test($("input[name = 'shoulder']").val())||
        !reg_dig.test($("input[name = 'arm']").val())||
        !reg_dig.test($("input[name = 'elbow']").val())||
        !reg_dig.test($("input[name = 'wrist']").val())||
        !reg_dig.test($("input[name = 'sleeve']").val())||
        !reg_dig.test($("input[name = 'chest']").val())||
        !reg_dig.test($("input[name = 'waist']").val())||
        !reg_dig.test($("input[name = 'clothes']").val())||
        !reg_dig.test($("input[name = 'hip']").val())||
        !reg_dig.test($("input[name = 'neck']").val())||
        $("input[name = 'shoulder']").val()=='0'||
        $("input[name = 'arm']").val()=='0'||
        $("input[name = 'elbow']").val()=='0'||
        $("input[name = 'wrist']").val()=='0'||
        $("input[name = 'sleeve']").val()=='0'||
        $("input[name = 'chest']").val()=='0'||
        $("input[name = 'waist']").val()=='0'||
        $("input[name = 'clothes']").val()=='0'||
        $("input[name = 'hip']").val()=='0'||
        $("input[name = 'neck']").val()=='0'
        ){
        alert('您点击了确认提交！所有数据只能由3位以下数字组成！且不能为0！请检查您的数据。')
            $("input[name = 'shoulder']").focus();
            return false;
        }
//数据都符合要求，返回true
return true;
}

/*
版型数据
 */
function beforeSubmit_user_design_b(){
if (confirm("保存后将覆盖原有的数据，您确定要保存吗？")) {
    if($("input[name = 'temp_caption']").val() == '' || $("input[name = 'temp_caption']").val() == null){
        alert("标题数据不能为空！");
        $("input[name = 'temp_caption']").focus();
        return false;
        }
    if($("input[name = 'temp_caption']").val().length>=20){
        alert('标题不能多于20个字符！');
        $("input[name = 'caption']").focus();
        return false;
        }
    //标题数据验证
    var reg_ch=/^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9_]){1,20}$/;//包含中文，英文和数字下划线验证
    var reg_eng=/^[a-zA-Z]*$/; //英文验证
    var reg_dig = /^\d{0,3}$/; //数字验证
    if(!reg_ch.test($("input[name = 'temp_caption']").val())){
        alert('标题只能由中文、英文和数字和下划线组成！');
        $("input[name = 'caption']").focus();
        return false;
        }
    if(
        !reg_dig.test($("input[name = 'temp_sleeve_length']").val())||
        !reg_dig.test($("input[name = 'temp_clothes_length']").val())||
        !reg_dig.test($("input[name = 'temp_neck_girth']").val())||
        !reg_dig.test($("input[name = 'temp_sleeve_width']").val())||
        !reg_dig.test($("input[name = 'temp_wrist_girth']").val())||
        !reg_dig.test($("input[name = 'temp_chest_girth']").val())||
        !reg_dig.test($("input[name = 'temp_waist_girth']").val())||
        !reg_dig.test($("input[name = 'temp_sweep_girth']").val())||
        !reg_dig.test($("input[name = 'temp_shoulder_width']").val())||
        !reg_dig.test($("input[name = 'temp_elbow_girth']").val())||
        $("input[name = 'temp_shoulder_width']").val()=='0'||
        $("input[name = 'temp_sleeve_length']").val()=='0'||
        $("input[name = 'temp_clothes_length']").val()=='0'||
        $("input[name = 'temp_neck_girth']").val()=='0'||
        $("input[name = 'temp_sleeve_width']").val()=='0'||
        $("input[name = 'temp_wrist_girth']").val()=='0'||
        $("input[name = 'temp_chest_girth']").val()=='0'||
        $("input[name = 'temp_waist_girth']").val()=='0'||
        $("input[name = 'temp_elbow_girth']").val()=='0'||
        $("input[name = 'temp_sweep_girth']").val()=='0'){
            alert('您点击了确保存，数据不符合要求！所有数据只能由3位以内数字组成！且不能为0！请检查您的数据。');
            $("input[name = 'temp_caption']").focus();
            return false;
        }
    return true;
}else{
    return false;
}
}

function beforeSubmit_user_design_l(){
    if (confirm("将按照您的调整为您生成新的版型数据，点击确定开始生成，点击取消回到原界面继续调整。")) {
    if($("input[name = 'temp_caption']").val() == '' || $("input[name = 'temp_caption']").val() == null){
        alert("标题数据不能为空！");
        $("input[name = 'temp_caption']").focus();
        return false;
        }
    if($("input[name = 'temp_caption']").val().length>=20){
        alert('标题不能多于20个字符！');
        $("input[name = 'caption']").focus();
        return false;
        }
    //标题数据验证
    var reg_ch=/^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9_]){1,20}$/;//包含中文，英文和数字下划线验证
    var reg_eng=/^[a-zA-Z]*$/; //英文验证
    var reg_dig = /^\d{0,3}$/; //数字验证
    if(!reg_ch.test($("input[name = 'temp_caption']").val())){
        alert('标题只能由中文、英文和数字和下划线组成！');
        $("input[name = 'caption']").focus();
        return false;
        }
    if(
        !reg_dig.test($("input[name = 'temp_shoulder_width']").val())||
        !reg_dig.test($("input[name = 'temp_sleeve_length']").val())||
        !reg_dig.test($("input[name = 'temp_clothes_length']").val())||
        !reg_dig.test($("input[name = 'temp_neck_girth']").val())||
        !reg_dig.test($("input[name = 'temp_sleeve_width']").val())||
        !reg_dig.test($("input[name = 'temp_wrist_girth']").val())||
        !reg_dig.test($("input[name = 'temp_chest_girth']").val())||
        !reg_dig.test($("input[name = 'temp_waist_girth']").val())||
        !reg_dig.test($("input[name = 'temp_sweep_girth']").val())||
        !reg_dig.test($("input[name = 'temp_elbow_girth']").val())||
        $("input[name = 'temp_shoulder_width']").val()=='0'||
        $("input[name = 'temp_sleeve_length']").val()=='0'||
        $("input[name = 'temp_clothes_length']").val()=='0'||
        $("input[name = 'temp_neck_girth']").val()=='0'||
        $("input[name = 'temp_sleeve_width']").val()=='0'||
        $("input[name = 'temp_wrist_girth']").val()=='0'||
        $("input[name = 'temp_chest_girth']").val()=='0'||
        $("input[name = 'temp_waist_girth']").val()=='0'||
        $("input[name = 'temp_elbow_girth']").val()=='0'||
        $("input[name = 'temp_sweep_girth']").val()=='0'){
            alert('您点击了另存，数据不符合要求！所有数据只能由3位以下数字组成！且不能为0！请检查您的数据。');
            $("input[name = 'temp_caption']").focus();
            return false;
        }
    return true;
}else{
    return false;
}
}