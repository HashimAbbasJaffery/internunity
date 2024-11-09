import { onMounted, ref, watchEffect, toValue } from "vue";
import axios from "axios";

const show_loading = (show_global_loading, is_loading) => {
    if(toValue(show_global_loading) === true) {
        is_loading.value = true;
    }
}

const hideAllLoadings = (is_loading, is_loading_more, show_global_loading) => {
    is_loading.value = false
    is_loading_more.value = false;
    show_global_loading.value = false;
}

export default function useFetch(url, show_global_loading) {
    const internshipsData = ref([]);
    const is_loading = ref(true);
    const is_loading_more = ref(true);
    const next = ref();


    const fetchData = () => {
        show_loading(show_global_loading, is_loading);
        is_loading_more.value = true;
        axios.get(toValue(url))
            .then(res => {
                internshipsData.value.push(...res.data.data);
                next.value = res.data.links[res.data.links.length - 1].url;
            })
            .catch(err => {
                console.log(err)
            })
            .finally(() => {
                hideAllLoadings(is_loading, is_loading_more, show_global_loading);
            })
    }

    watchEffect(() => {
        fetchData();
    })

    return { internshipsData, is_loading, is_loading_more, next };

}
