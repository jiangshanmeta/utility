<template>
    <div class="list von-radio">
        <label
            v-for="(item,index) in candidate"
            class="item item-borderless" 
            :class="[
                'item-icon-' + position,
            ]"
        >
            <div class="hairline-top" v-if="index>0"></div>
            <input type="radio" v-model="currentValue" :value="item.value">
            <i class="icon ion-ios-checkmark" :class="getIconColor(item.value)"></i>
            <span v-text="item.label"></span>
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
        position:{
            type:String,
            default:'left',
        },
        theme:{
            type:String,
            default:'assertive'
        },
        candidate:{
            type:Array,
            required:true,
        },
        value:{
            type:[Number,String],
            required:true,
        }
    },
    methods:{
        getIconColor(value){
            if(value === this.currentValue){
                return this.theme
            }
            return 'gray'

        }
    },
    created(){
        this._asyncProp('currentValue','value');
        this._notifyInput('currentValue');
    },
}


</script>