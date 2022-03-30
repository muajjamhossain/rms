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
                    if(unread.data.status == 1) {
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
                if(notification.status == 1) {
                    this.count++;
                }
                document.getElementById('orderRequestNoty').muted;
                document.getElementById('orderRequestNoty').play();
            });
        }
    }
</script>
