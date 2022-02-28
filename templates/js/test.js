let app = new Vue({
    el:"#app",
    data:{
        api: [],
        selected: null,
        prev: [],
        statistics: 0
    },
    computed:{
        
    },
    methods:{
        get(){
            post("api/get.php", null, msg=>{
                this.api = JSON.parse(msg)
                this.selected = this.getRandom(0, this.api.length - 1)
                this.prev.push(this.selected)
                // console.log(this.api)
            })
        },
        getStart(){

        },
        getRandom(min, max){
            return Math.floor(Math.random() * (max - min + 1) + min)
        },
        draw(min, max){
            this.selected = this.getRandom(min, max)
            if(this.prev.includes(this.selected)){
                if(this.prev.length <= (max - min)){
                    this.draw(min, max)
                }else{
                    if(this.statistics > 0){
                        alert("Ты не такой тупой как я думал)")
                    }else if(this. statistics == 0){
                        alert("Никакого прогресса!")
                    }else{
                        alert("Ты слишком туп для этого мира...")
                    }
                    
                    window.location.href = ""
                }
            }else{
                this.prev.push(this.selected)                    
            }
        },
        updateTest(id, e, rating){
            let fd = new FormData();
            fd.append("id", id);
            fd.append("e", e);
            fd.append("input", rating)
            console.log(e)
            post("api/update-rating.php", fd, (msg) => {
                this.api = JSON.parse(msg)
                this.draw(0, this.api.length - 1)
                
            });
        },
        // again(ololo){
        //     this.selected = Math.ceil(Math.random() * this.api.length) - 1
        //     console.log(ololo)
        //     if(this.selected == ololo){
        //         this.again(ololo)
        //     }
        // }
    },
    beforeMount(){
        this.get()
    }
})