import axios from 'axios';

axios.defaults.headers.common = {
    "Content-Type": "application/json;charset=utf-8",
};

export const getUserInfo = async (id) => {
    const response = await axios.get('/api/users/profile?id=' + id);
    console.log(response.data[0]);
    return response.data[0];
}

export const editUserData = async (userID, name, surname, email, password, currentEmail) => {
    const data = {
        userID,
        name,
        surname,
        email,
        password,
        currentEmail,
    };
    const response = await axios.post("http://project-php:8081/server/editUserData.php", JSON.stringify(data), {
        headers: {
            "Content-Type": "application/json;charset=utf-8",
        }
    });

    return response.data;
}

export const getOrdersInfo = async (id) => {
    // const response = await axios.get('http://project-php:8081/server/userOrders.php?id=' + id);
    // return response.data;

    return "test";
}
