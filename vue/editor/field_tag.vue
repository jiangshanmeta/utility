<template>
    <el-checkbox-group v-model="selected">
        <el-checkbox v-for="item in candidate" :key="item.value" :label="item.value">
            {{item.label}}
        </el-checkbox>
    </el-checkbox-group>
</template>

<script>
export default{
    data (){
        return {
            selected:this.value,
        }
    },
    props:{
        value:{
            type:Array,
            required:true,
        },
        candidate:{
            type:Array,
            required:true,
        },
    },
    watch:{
        value(newVal){
            this.selected = newVal;

        },
        selected(newVal){
            this.$emit('input',newVal);
        }
    },
}
</script>