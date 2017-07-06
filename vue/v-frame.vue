<template>
<div class="v-frame-container">
    <div :style="{paddingBottom:ratio*100+'%'}"></div>
    <iframe :src="src"   class="v-frame-item" allowfullscreen frameborder='0'></iframe>
</div>
</template>

<script>
export default {
    props:{
        src:{
            type:String,
            required:true
        },
        ratio:{
            type:[Number,String],
            default:1
        }
    }
}
</script>

<style scoped>
.v-frame-container{
    position:relative;
}
.v-frame-item{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
}
</style>