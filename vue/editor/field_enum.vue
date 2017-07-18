<template>
    <el-select v-model="enum1">
        <el-option v-for="item in candidate" :key="item.value" :value="item.value" :label="item.label">

        </el-option>
    </el-select>
</template>

<script>

export default{
    data(){
        return {
            enum1:this.value,
        }
    },
    props:{
        value:{
            type:Number,

        },
        candidate:{
            type:Array,
            required:true,
        }
    },
    watch:{
        value(newVal){
            this.enum1 = newVal;
        },
        enum1(newVal){
            this.$emit('input',newVal);
        }
    },
}
</script>