<template>
    <div class="list list-ios von-checkbox">
        <label
            v-for="(item,index) in candidate"
            class="item item-borderless" 
            :class="[
                'item-icon-' + position,
            ]"
        >
            <div class="hairline-top" v-if="index>0"></div>
            <input type="checkbox" v-model="currentValue" :value="item.value">
            <span>{{item.label}}</span>
            <i class="" :class="getIconColor(item.value)"></i>
            <div class="hairline-bottom" v-if="index<candidate.length-1"></div>
        </label>

    </div>
</template>

<script>
import {formHelper} from "./mixins"
export default{
    mixins:[formHelper],
    data(){
        return {
            currentValue:this.value,
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
        theme:{
            type:String,
            default:'assertive'
        },
        position:{
            type:String,
            default:'right'
        },
    },
    computed:{
        currentValueHash(){
            return this.currentValue.reduce(function(obj,item){
                obj[item] = item;
                return obj;
            },{});
        }
    },
    methods:{
        getIconColor(value){
            if(this.currentValueHash.hasOwnProperty(value)){
                return this.theme + ' icon ion-ios-checkmark-empty';
            }
            return '';
        },
    },
    created(){
        this._asyncProp('currentValue','value');
        this._notifyInput('currentValue');
    }
}
</script>

<style>
.von-checkbox .item{
    padding:15px 15px 15px 30px;
}
.von-checkbox .item-icon-left .icon{
    left:-6px;
    font-size:36px;
}
</style>