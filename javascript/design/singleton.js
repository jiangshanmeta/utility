// 一个类只加工一次，缓存加工好的单例类
const classMap = new Map();

// 工厂函数，将一个类加工成单例类
function Singleton(fn){
    if(!classMap.has(fn)){
        let instance = null;
        let wrapper = function(...rest){
            if(!instance){
                instance = new fn(...rest);
            }
            return instance;
        }

        classMap.set(fn,wrapper)
    }
    return classMap.get(fn);
}

export default Singleton;