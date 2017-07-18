<template>
    <el-input v-model="editValue"></el-input>
</template>

<script>
export default{
    data(){
        return {
            editValue:this.value,
        }
    },
    props:{
        value:{
            type:String,
            default:'',
        }
    },
    watch:{
        value(newValue){
            if(newValue !== this.editValue){
                this.editValue = newValue;
            }
        },
        editValue(newValue){
            this.$emit('input',newValue);
        }
    }
}
</script>