<template>
    <el-select v-model="currentValue" :placeholder="placeholder" filterable>
        <el-option v-for="item in candidate" :key="item.value" :value="item.value" :label="item.label">

        </el-option>
    </el-select>
</template>

<script>
import {formHelper} from "./mixins"
export default{
    data (){
        return {
            currentValue:this.value,
        }
    },
    mixins:[formHelper],
    props:{
        value:{

        },
        candidate:{
            type:Array,
            required:true,
        },
        placeholder:{
            default:'',
        },

    },
    created(){
        this._asyncProp('currentValue','value');
        this._notifyInput('currentValue');
    },
}
</script>