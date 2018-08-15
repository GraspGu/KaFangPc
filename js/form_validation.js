/*在线版型设计数据提交表单验证*/
function beforeSubmit(){
    $("#submit_one").click(function(event) {
        if($("input[name = caption]").value == '' || $("input[name = caption]").value == null){
            alert('标题不能为空！');
            $("input[name = caption]").focus();
            return false;
                }
        if(form.caption.value.length>=20){
            alert('标题不能多于20个字符！');
            form.caption.focus();
            return false;
                    }
        //标题数据验证
        var reg_ch=/^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9_]){1,20}$/;//包含中文，英文和数字下划线验证
        var reg_eng=/^[a-zA-Z]*$/; //英文验证
        var reg_dig = /^\d{0,3}$/; //数字验证
        if(!reg_ch.test(form.caption.value)){
            alert('标题只能由中文、英文和数字和下划线组成！');
            form.caption.focus();
            return false;
            }
        //量体数据验证，不为空的情况下。暂存数据可以为空
        //shoulder
        if(form.shoulder.value!=''){
            if(!reg_dig.test(form.shoulder.value)||form.shoulder.value=='0'){
            alert('肩宽数据只能为3位以内数字！且不能为0！');
            form.shoulder.focus();
            return false;
        }
        }
        //arm
        if(form.arm.value!=''){
            if(!reg_dig.test(form.arm.value)||form.arm.value=='0'){
            alert('上臂围数据只能为3位以内数字！且不能为0！');
            form.arm.focus();
            return false;
        }
        }
        //肘围elbow
        if(form.elbow.value!=''){
            if(!reg_dig.test(form.elbow.value)||form.elbow.value=='0'){
            alert('上肘围数据只能为3位以内数字！且不能为0！');
            form.elbow.focus();
            return false;
        }
        }
        //腕围wrist
        if(form.wrist.value!=''){
            if(!reg_dig.test(form.wrist.value)||form.wrist.value=='0'){
            alert('腕围数据只能为3位以内数字！且不能为0！');
            form.wrist.focus();
            return false;
        }
        }
        //袖长sleeve
        if(form.sleeve.value!=''){
            if(!reg_dig.test(form.sleeve.value)||form.sleeve.value=='0'){
            alert('袖长数据只能为3位以内数字！且不能为0！');
            form.sleeve.focus();
            return false;
        }
        }
        //胸围chest
        if(form.chest.value!=''){
            if(!reg_dig.test(form.chest.value)||form.chest.value=='0'){
            alert('胸围数据只能为3位以内数字！且不能为0！');
            form.chest.focus();
            return false;
        }
        }
        //前胸宽brisket
        if(form.brisket.value!=''){
            if(!reg_dig.test(form.brisket.value)||form.brisket.value=='0'){
            alert('前胸宽数据只能为3位以内数字！且不能为0！');
            form.brisket.focus();
            return false;
        }
        }
        //后背宽back
        if(form.back.value!=''){
            if(!reg_dig.test(form.back.value)||form.back.value=='0'){
            alert('后背宽数据只只能为3位以内数字！且不能为0！');
            form.back.focus();
            return false;
        }
        }
        //腰围/小肚围waist
        if(form.waist.value!=''){
            if(!reg_dig.test(form.waist.value)||form.waist.value=='0'){
            alert('腰围/小肚围数据只能为3位以内数字！且不能为0！');
            form.waist.focus();
            return false;
        }
        }
        //前衣长clothes
        if(form.clothes.value!=''){
            if(!reg_dig.test(form.clothes.value)||form.clothes.value=='0'){
            alert('前衣长数据只能为3位以内数字！且不能为0！');
            form.clothes.focus();
            return false;
        }
        }
        //后衣长back_clothes
        if(form.back_clothes.value!=''){
            if(!reg_dig.test(form.back_clothes.value)||form.back_clothes.value=='0'){
            alert('后衣长数据只能为3位以内数字！且不能为0！');
            form.back_clothes.focus();
            return false;
        }
        }
        //臀围hip
        if(form.hip.value!=''){
            if(!reg_dig.test(form.hip.value)||form.hip.value=='0'){
            alert('后衣长数据只能为3位以内数字！且不能为0！');
            form.hip.focus();
            return false;
        }
        }
        //上领围neck
        if(form.neck.value!=''){
            if(!reg_dig.test(form.neck.value)||form.neck.value=='0'){
            alert('上领围数据只能为3位以内数字！且不能为0！');
            form.neck.focus();
            return false;
        }
        }
    });
//确认提交检查
    $("#submit_two").click(function(event) {
            //暂存和确认数据标题都需要进行验证
            if(form.caption.value.length>=20){
                alert('标题不能多于20个字符！');
                form.caption.focus();
                return false;
                }
            if($("input[name = caption]").value == '' || $("input[name = caption]").value == null){
                alert('标题不能为空！');
                $("input[name = caption]").focus();
                return false;
            }

            //标题数据验证
            var reg_ch=/^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9_]){1,20}$/;//包含中文，英文和数字下划线验证
            var reg_eng=/^[a-zA-Z]*$/; //英文验证
            var reg_dig = /^\d{1,3}$/; //数字验证
            if(!reg_ch.test(form.caption.value)){
                alert('标题只能由中文、英文和数字和下划线组成！');
                form.caption.focus();
                return false;
                }
            if(!reg_dig.test(form.shoulder.value)||!reg_dig.test(form.arm.value)||!reg_dig.test(form.elbow.value)||!reg_dig.test(form.wrist.value)||!reg_dig.test(form.sleeve.value)||!reg_dig.test(form.chest.value)||!reg_dig.test(form.brisket.value)||!reg_dig.test(form.back.value)||!reg_dig.test(form.waist.value)||!reg_dig.test(form.clothes.value)||!reg_dig.test(form.back_clothes.value)||!reg_dig.test(form.hip.value)||!reg_dig.test(form.neck.value)||form.shoulder.value=='0'||form.arm.value=='0'||form.elbow.value=='0'||form.wrist.value=='0'||form.sleeve.value=='0'||form.chest.value=='0'||form.brisket.value=='0'||form.back.value=='0'||form.waist.value=='0'||form.clothes.value=='0'||form.back_clothes.value=='0'||form.hip.value=='0'||form.neck.value=='0'){
                alert('您点击了确认提交！所有数据只能由3位以下数字组成！且不能为0！请检查您的数据。');
                form.caption.focus();
                return false;
                }
        });
return true;
}