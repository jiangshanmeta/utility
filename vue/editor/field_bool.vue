<template>
    <field-enum 
        v-model="editValue" 
        :candidate="candidate"
    ></field-enum>

</template>

<script>
import fieldEnum from './field_enum'
let boolCandidate = [
                {value:0,label:'否'},
                {value:1,label:'是'},
            ];
export default{
    data (){
        return {
            editValue:this.value,
            candidate:boolCandidate,
        }
    },
    watch:{
        editValue(newVal){
            this.$emit('input',newVal);
        },
        value(newVal){
            if(newVal !== this.editValue){
                this.editValue = newVal;
            }
        },
    },
    props:{
        value:{
            type:Number,
            default:0,
        }
    },
    components:{
        fieldEnum,
    }
}
</script>