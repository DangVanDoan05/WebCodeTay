import axiosDefault from 'axios'

export const apiGetProvinces = () => new Promise(async(resolve,reject))=>
{
    try
    {
        const response = await axiosDefault({
            method: 'get',
            url: 'https://provinces.open-api.vn/api/'
        })
        resolve(response)
    }
    catch (error){
        reject(error)
    }
    
}