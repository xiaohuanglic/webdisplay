<template>

	<div>
	   <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
     
	 <router-view v-if="isRounterAlive"></router-view>
	 		
	</div>

</template>
<script>
	export default{
		provide:function(){
			return{
    		reloader: this.reloader
    		} // this will result in error `Cannot read property 'length' of undefined`
  		},
  		data: function () {
                return {
                    isRounterAlive:true,
            }
        },
        methods:{
         	reloader(){
         		this.isRounterAlive = false;
         		this.$nextTick(function(){
         			this.isRounterAlive = true;
         		})
         	}
        }
	}

</script>
<sytle scoped>
html, body {
  padding: 0;
  margin: 0;
}


</sytle>