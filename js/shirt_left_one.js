    var index = 0; // 保存当前所在项
    /* 是否允许点击滑动动画,如果正在执行动画的过程中,
    则禁止点击,如果动画完成后,则允许点击,
    避免由于连点,出现画面不正常问题. */
    var allowClick = true; //
 // 页面加载完成后调用
        // $(function(){
        //     index = 1; // 初始显示第2项
        //     /* 注意：第一项是用来缓存末项的,实现无缝连接准备的,所以最开始显示的应该是第2项 */
        //     $(".banner_2").css("bottom", "300px"); // 准备初始显示项
        //     // 上一页
        //     $(".last_2").on("click", function(){
        //         if(allowClick){
        //             allowClick = false;
        //             index--; // 上一页,--
        //             // 如果已经到了最开始过后，动画完成后,定位到末项
        //             if(index == 0){
        //                 $(".banner_2").animate({bottom: (index * 300) + 'px'}, "fast", "swing", function () {
        //                     index = 4;
        //                     $(".banner_2").css("bottom", "1200px"); // 定位到末项
        //                     allowClick = true;
        //                 });
        //             }else{
        //                 $(".banner_2").animate({bottom: (index * 300) + 'px'}, "fast", "swing", function () {
        //                     allowClick = true;
        //                 });
        //             }
        //         }
        //     });
        index = 1; // 初始显示第2项
         /* 注意：第一项是用来缓存末项的,实现无缝连接准备的,所以最开始显示的应该是第2项 */
        $(".banner_1").css("bottom", "320px"); // 准备初始显示项
        function lunbo1(){
            if(allowClick){
                allowClick = false;
                if(index <= 5){
                    index ++; // 下一页++
                    if(index == 5){
                        $(".banner_1").animate({bottom: (index * 320) + 'px'}, "1000", "swing", function () {
                            index = 1;
                            $(".banner_1").css("bottom", "320px");
                            allowClick = true;
                        });
                    }else{
                        $(".banner_1").animate({bottom: (index * 320) + 'px'}, "1000", "swing", function () {
                            allowClick = true;
                        });
                    }
                }
            }
        };
        setInterval("lunbo1()",2000);