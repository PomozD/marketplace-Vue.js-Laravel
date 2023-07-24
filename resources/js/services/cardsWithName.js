import axios from 'axios';

axios.defaults.headers.common = {
    "Content-Type": "application/json;charset=utf-8",
};

export const getItemWithName = async (name) => {
    const response = await axios.get('http://project-php:8081/server/getCardsWithName.php?name=' + name);
    return response.data;
}

export const getCountAndPrice = async (id) => {
    const response = await axios.get('http://project-php:8081/server/getCardsForCartProfile.php?id=' + id);
    return response.data;
}