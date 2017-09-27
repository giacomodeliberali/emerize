<?php
    class MessageHandler {
        
        var $message = "undefined";
        var $state = "undefined";
        var $details = "undefined";
        
        function MessageHandler($_message, $_state, $_details){
            $this->message = $_message;
            $this->state = $_state;
            $this->details = $_details;
        }
        
        function toJSON(){
            return json_encode($this);
        }
    }
    
?>