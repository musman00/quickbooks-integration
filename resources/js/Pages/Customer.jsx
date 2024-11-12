import AppLayout from '@/Layouts/AppLayout.jsx';
import React, { useState, useEffect } from 'react';
import axios from "axios";
import CustomTable from "@/Components/CustomTable.jsx";
import {Button, Tag} from "antd";
import { message } from 'antd';

export default function Customer() {
    //set customer listing data
    const [customers, setCustomers] = useState([]);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        customerListing();
    }, []);

    const customerListing = () => {
        setLoading(true);

        axios.get(route("api.quickbook.customers"))
            .then((response) => {
                if (response.data.success) {
                    setCustomers(response.data.data);
                } else {
                    message.error(response.data.message ?? "Error while fetching customers. Please try again.");
                }
            })
            .catch((error) => {
                const errorMessage = error.response?.data?.message || "Failed to send request to server. Please try again.";
                message.error(errorMessage);
            })
            .finally(() => {
                setLoading(false);
            });
    };



    const columns = [
        {
            title: 'Name',
            dataIndex: 'customer_name',
            key: 'customer_name',
            render: (text) => <a style={{ color: '#1777fe' }}>{text}</a>,
        },
        {
            title: 'Email',
            dataIndex: 'email',
            key: 'email',
            render: (text) => text ? text : '-',
        },
        {
            title: 'Phone',
            dataIndex: 'phone',
            key: 'phone',
            render: (text) => text ? text : '-',
        },
        {
            title: 'Balance',
            dataIndex: 'current_balance',
            key: 'current_balance',
            render: (text) => text ? text : '-',
        },
        {
            title: 'Currency',
            dataIndex: 'currency_code',
            key: 'currency_code',
            render: (text) => text ? text : '-',
        },
        {
            title: 'Status',
            dataIndex: 'status',
            key: 'status',
            render: (status) => <Tag color="blue-inverse" key={status}>{status ? 'Active' : "Inactive"}</Tag>,
        },
        {
            title: 'Created At',
            dataIndex: 'created_at',
            key: 'created_at',
            render: (text) => text ? text : '-',
        }
    ];

    // Prepare the dataSource for the Custom Table component
    const dataSource = customers?.map((customer, index) => ({
        key: index+1,
        ...customer
    })) || [];

    return (
        <AppLayout>
            <div className="py-6">
                <div className="mx-auto max-w-8xl sm:px-6 lg:px-8">

                    <Button disabled={loading} onClick={customerListing} color="primary" variant="outlined" className={"mb-3"}>
                        <svg className="mt-0.5 mr-1" width={20} viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.3935 5.37371C18.0253 6.70569 19.8979 10.7522 18.5761 14.4118C17.6363 17.0135 15.335 18.7193 12.778 19.0094M12.778 19.0094L13.8253 17.2553M12.778 19.0094L14.4889 20M9.60651 18.6263C5.97465 17.2943 4.10205 13.2478 5.42394 9.58823C6.36371 6.98651 8.66504 5.28075 11.222 4.99059M11.222 4.99059L10.1747 6.74471M11.222 4.99059L9.51114 4"
                                stroke= { loading ? "grey" : "#1677FF"} strokeLinecap="round" strokeLinejoin="round"/>
                        </svg>
                        Sync Customers
                    </Button>

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <div className="relative overflow-x-auto" style={{height: "88vh", overflowY: "auto"}}>
                                <CustomTable columns={columns} dataSource={dataSource} pagination={false} loading={loading} />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </AppLayout>
    );
}
