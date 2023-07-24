import axios from 'axios';

axios.defaults.headers.common = {
    "Content-Type": "application/json;charset=utf-8",
};

export const getCategory = async () => {
    const response = await axios.get('/api/categories');
    console.log(response.data);
    return response.data;
}
