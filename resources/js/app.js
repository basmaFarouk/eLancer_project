import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Echo.private(`App.Models.User.${userId}`)
            .notification(function(data){
                // alert(data.body)
                $('#notificationsList').prepend(`  <li class="notifications-not-read">
                <a href="${data.url}?notify_id=${data.id}">
                    <span class="notification-icon"><i class="icon-material-outline-group"></i></span>
                    <span class="notification-text">

                            <strong style="color: red">*</strong>
                        ${data.body}
                    </span>
                </a>
            </li>`);
           let count = Number($('#newNotifications').text()) //عشان يجيبلي التيكست اللي جواها
           count++
           if(count>99){
            count="99+";
           }
           $('#newNotifications').text(count)
            })


window.Echo.join(`messages.${userId}`)  //join because it is presense channel
            .listen('.message.created',function(data){
                alert(data.message.message)
            })
