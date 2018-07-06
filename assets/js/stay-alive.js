function test_stay_alive(members) {
    console.log(members);
}
jQuery(document).ready(function(){
    console.log("StayAlive: loaded");
    var StayAlive = function() {

        this.pusher = null;
        this.channel = null;
        this.current_user_id = config.current_user_id
        this.channel_name = config.channel_name
        this.event_name = config.event_name
        this.status = false

        this.credentials = function() {
            return config.credentials
        }

        this.subscribe = function() {
            this.pusher = new Pusher(this.credentials().pusher_key, { cluster: this.credentials().pusher_cluster , authEndpoint: config.auth_url});
            this.channel = this.pusher.subscribe(this.channel_name);
        }

        this.unsubscribe = function() {
            this.pusher.unsubscribe(this.channel_name);
        }

        this.count = function() {
            return this.channel.members.count
        }

        this.me = function() {
            return this.channel.members.me
        }

        this.users = function() {
            return this.channel.members.members
        }

        this.online = function() {
            stay_alive.subscribe()
            this.channel.bind("pusher:subscription_succeeded", function(members)  {

                jQuery("ul.stay_alive_users").empty()
                for(var i = 1; i <= members.count; i++) {
                    jQuery("ul.stay_alive_users").append("<li>"+ members.members[i].name +"</li>")
                }
                
            });

            this.channel.bind("pusher:member_added", function(member) {
                members = stay_alive.users()
                jQuery("ul.stay_alive_users").empty()
                for(var i = 1; i <= stay_alive.count(); i++) {
                    jQuery("ul.stay_alive_users").append("<li>"+ members[i].name +"</li>")
                }
            });

            this.channel.bind("pusher:member_removed", function(member) {
                members = stay_alive.users()
                
                jQuery("ul.stay_alive_users").empty()
                for(var i = 1; i <= stay_alive.count(); i++) {
                    jQuery("ul.stay_alive_users").append("<li>"+ members[i].name +"</li>")
                }

            });
        }
    }

    var stay_alive = new StayAlive()
    stay_alive.online()
})