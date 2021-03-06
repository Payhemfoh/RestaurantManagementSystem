import { errorModal } from "./errorFunction.js";

export class Chat{
    private instance : boolean;
    private status : number;
    private file : string;

    constructor(filename : string){
        this.instance = false;
        this.status = 0;
        this.file = filename;
    }

    get getInstance():boolean{
        return this.instance;
    }

    get getStatus():number{
        return this.status;
    }

    get getFile():string{
        return this.file;
    }
    

    public update() : void{
        if(!this.instance){
            this.instance = true;
            $.ajax("../php/chatroom_process.php",{
                method:"post",
                dataType:"json",
                data:{
                    function:"update",
                    state:this.status,
                    file:this.file
                },
                success:(data)=>{
                    if(data.text){
                        for(let i =0;i<data.text.length;++i){
                            $("#chat-area").append(""+data.text[i]+"<br>");
                        }
                        document.getElementById("chat-area")!.scrollTop = document.getElementById("chat-area")!.scrollHeight;
        
                        this.status = data.state;
                    }
                    this.instance = false;
                },
                error:errorModal
            });
        }
    }

    public getState() : void{
        if(!this.instance){
            this.instance = true;
            $.ajax("../php/chatroom_process.php",{
                method:"post",
                dataType:"json",
                data:{
                    function:"getState",
                    file:this.file
                },
                success:(data)=>{
                    if(data.text){
                    for(let i =0;i<data.text.length;++i){
                        $("#chat-area").append(""+data.text[i]+"<br>");
                    }
                    document.getElementById('chat-area')!.scrollTop = document.getElementById('chat-area')!.scrollHeight;
                    this.status = data.state;
                    this.instance = false;
                    }
                }
            }); 
        }
    }

    public sendMsg(msg:string,username:string):void{
        this.update();
        $.ajax("../php/chatroom_process.php",{
            method:"post",
            dataType:"json",
            data:{
                function:"send",
                message:msg,
                username:username,
                file:this.file
            },
            success:()=>{this.update();}
        });
    }
}