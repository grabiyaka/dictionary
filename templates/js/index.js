let app = new Vue({
    el:"#app",
    data:{
        api: [],
        editWord: 0,
        search: null,
        auth: null
    },
    computed: {
        sortedApi(){
            let output = []
            for(key in this.api){
                let visible = true
                if(this.search){
                    visible = this.api[key].en.toLowerCase().includes( this.search.toLowerCase() ) || 
                        this.api[key].ru.toLowerCase().includes( this.search.toLowerCase() ) 
                }
                output[key] = {
                    visible: visible,
                    ...this.api[key]
                }
            }
            // console.log(output)
            return output.sort((a, b) => (a.rating > b.rating) ? 1: -1)
        }
    },
    methods:{
        get(){
            post("getUserWords", null, msg=>{
                this.api = JSON.parse(msg)
                // console.log(this.api)
            })
        },
        add($event) {
            let fd = new FormData($event.target);
            post("addWord", fd, (msg) => {
                console.log(msg)
            this.api.push(JSON.parse(msg));
            $event.target.reset();
            alert("add");
            });
            
        },
        updateWord(id, $event) {
            let fd = new FormData();
            fd.append("id", id);
            fd.append("value", $event.target.value);
            fd.append("input", $event.target.name)
            post("update", fd, (msg) => {});
        },
        deleteWord(id) {
            if (confirm('Ты удаляешь это слово?')){
                let fd = new FormData();
                fd.append("id", id);
                post("delete", fd, (msg) => {
                this.api = this.api.filter(word => word.id !== id);
                this.searchApi = this.searchApi.filter(word => word.id !== id);
                });
                alert("Удалено!");
            }
        },
        updateRating(id, n, index){
            let fd = new FormData();
            fd.append("id", id);
            fd.append("value", n);
            fd.append("input", "rating")
            console.log(n)
            post("updateRating", fd, (msg) => {
                this.api.forEach(e => {
                    if(e.id == id){
                        e.rating = n
                    }
                })
            });
        }
    },
    beforeMount(){
        this.get()
    }
})