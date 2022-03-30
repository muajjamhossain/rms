<template>
        <span class="badge badge-primary">{{ count }}</span>
        
</template>

<script>
    export default {
        props:['unreads', 'userid'],
        data(){
            return {
                unreadNotifications : this.unreads,
                count : 0
            }
        },
        methods: {
            amount() {
                let n = 0;
                this.unreadNotifications.forEach(function(unread){
                    if(unread.data.status == 2) {
                        n++;
                    }
                });
                return n;
            }
        },        
        mounted() {
            console.log('Component mounted.');
            this.count = this.amount();
            Echo.private('App.User.' + this.userid)
            .notification((notification) => {
                console.log(notification);
                let newUnreadNotifications = {data:{order_id:notification.order_id,rstrt_slug:notification.rstrt_slug}}
                this.unreadNotifications.push(newUnreadNotifications);
                document.getElementById('confirmRequestNoty').muted;
                document.getElementById('confirmRequestNoty').play();
                let num = 1;
                for (var i = 0; i < this.unreadNotifications.length; i++) {
                    if(this.unreadNotifications[i].data.status == 2) {
                        num++;
                    }
                }
                this.count = num;
            });
        }
    }
</script>
