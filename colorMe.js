 var start = Array();
        var cnt = 0;
        $(document).ready(function() {
         $('#myCanvas').click(function(e) {
             
             var canvas = document.getElementById("myCanvas");
             var context = canvas.getContext("2d");
             
                var offset = $(this).offset();
                var xOfset = e.clientX - offset.left;
                var yOfset = e.clientY - offset.top;
                if(typeof(start.x) == 'undefined'){
                    context.moveTo(xOfset, yOfset);
                }else{
                    context.lineTo(xOfset, yOfset);
                    context.moveTo(xOfset, yOfset);
                    context.lineWidth = 3;
                    context.strokeStyle = 'orange';
                    context.stroke();
                }
                start.x = xOfset;
                start.y = yOfset;
                var pointsHtml = $('#points').html();
                $('#points').html(pointsHtml+'<input type="hidden" name="x['+cnt+']" id="x['+cnt+']" value="'+xOfset+'" id="pointx" /><input  value="'+yOfset+'" type="hidden" name="y['+cnt+']" id="pointy" />');
                cnt++;
    });
    });
    
    
    $(function() {
                // there's the gallery and the trash
                var $gallery = $(".my-options"),
                        $trash = $(".my-room");
                // let the gallery items be draggable
                $("div.option", $gallery).draggable({
                    //cancel: "a.ui-icon", // clicking an icon won't initiate dragging
                    //revert: "invalid", // when not dropped, the item will revert back to its initial position
                    containment: "document",
                    helper: "clone",
                    cursor: "move"
                });
                // let the trash be droppable, accepting the gallery items
                $trash.droppable({
                    accept: ".my-options > div",
                    activeClass: "ui-state-highlight",
                    drop: function(event, ui) {
                        console.log(ui);
                        var bHeight = $('body').data('height');
                        var item = ui.draggable;
                        var ratio = $(item).children('img').data('height')/bHeight;
                        var diff = (($(item).children('img').height()-(ratio*$('.my-room').parent('div').height()))/$(item).children('img').height())*100
                        console.log(bHeight,$(item).children('img').data('height'));
                        $(item).children('img').height(ratio*$('.my-room').parent('div').height());
                        $(item).children('img').width($(item).children('img').width()-((diff/100)*$(item).children('img').width()));
                        $(item).css('top',ui.offset.top);
                        $(item).css('left',ui.offset.left);
                        $(item).css('position','absolute');
                        $(item).removeClass('ui-widget-content');
                        $(item).appendTo($('.left'));
                        $(this).append($(item).clone());//clone the dragged element
//                        $item.find("a.ui-icon-trash").remove();
//                        $item.append(recycle_icon).appendTo($list)
                        //deleteImage(ui.draggable);
                    }
                });
                // let the gallery be droppable as well, accepting items from the trash
//                $gallery.droppable({
//                    accept: "#trash li",
//                    activeClass: "custom-state-active",
//                    drop: function(event, ui) {
//                        recycleImage(ui.draggable);
//                    }
//                });
                // image deletion function
                var recycle_icon = "<a href='link/to/recycle/script/when/we/have/js/off' title='Recycle this image' class='ui-icon ui-icon-refresh'>Recycle image</a>";
                function deleteImage($item) {
                    $item.fadeOut(function() {
                        var $list = $("ul", $trash).length ?
                                $("ul", $trash) :
                                $("<ul class='gallery ui-helper-reset'/>").appendTo($trash);
                        $item.find("a.ui-icon-trash").remove();
                        $item.append(recycle_icon).appendTo($list).fadeIn(function() {
                            $item
                                    .animate({width: "48px"})
                                    .find("img")
                                    .animate({height: "36px"});
                        });
                    });
                }
                // image recycle function
                var trash_icon = "<a href='link/to/trash/script/when/we/have/js/off' title='Delete this image' class='ui-icon ui-icon-trash'>Delete image</a>";
                function recycleImage($item) {
                    $item.fadeOut(function() {
                        $item
                                .find("a.ui-icon-refresh")
                                .remove()
                                .end()
                                .css("width", "96px")
                                .append(trash_icon)
                                .find("img")
                                .css("height", "72px")
                                .end()
                                .appendTo($gallery)
                                .fadeIn();
                    });
                }
                // image preview function, demonstrating the ui.dialog used as a modal window
                function viewLargerImage($link) {
                    var src = $link.attr("href"),
                            title = $link.siblings("img").attr("alt"),
                            $modal = $("img[src$='" + src + "']");
                    if ($modal.length) {
                        $modal.dialog("open");
                    } else {
                        var img = $("<img alt='" + title + "' width='384' height='288' style='display: none; padding: 8px;' />")
                                .attr("src", src).appendTo("body");
                        setTimeout(function() {
                            img.dialog({
                                title: title,
                                width: 400,
                                modal: true
                            });
                        }, 1);
                    }
                }
                // resolve the icons behavior with event delegation
                $("ul.gallery > li").click(function(event) {
                    var $item = $(this),
                            $target = $(event.target);
                    if ($target.is("a.ui-icon-trash")) {
                        deleteImage($item);
                    } else if ($target.is("a.ui-icon-zoomin")) {
                        viewLargerImage($target);
                    } else if ($target.is("a.ui-icon-refresh")) {
                        recycleImage($item);
                    }
                    return false;
                });
                
                $.ajax({
                    url: "ajax/canvas.php",
                    type:' POST',
                    data:{x:$('#x').val(),y:$('#x').val(),image:$('.my-room').attr(' src')}
                    }).done(function(data) {
                    $('.my-room').attr(' src',data);
                    });
            });