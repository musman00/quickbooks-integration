import AppLayout from '@/Layouts/AppLayout.jsx';
import React, { useState, useEffect } from 'react';
import axios from "axios";
import CustomTable from "@/Components/CustomTable.jsx";
import {Button, Tag} from "antd";
import { message } from 'antd';

export default function Invoice() {
    const [invoiceData, setInvoiceData] = useState([]);
    const [loading, setLoading] = useState({
        invoice: false
    });

    useEffect(() => {
        invoiceListing();
    }, []);

    const invoiceListing = () => {
        setLoading(data => ({ ...data, invoice: true }));
        axios.get(route("api.quickbook.invoices"))
            .then(response => {
                setLoading(data => ({ ...data, invoice: false }));
                if (response.data.success) {
                    setInvoiceData(response.data.data);
                } else {
                    handleError(response.data.message);
                }
            })
            .catch(error => handleError(`Error while fetching invoices: ${error}`));
    };

    const handleError = (messageText) => {
        message.error(messageText);
    };


    const columns = [
        {
            title: 'invoice Id',
            dataIndex: 'invoice_id',
            key: 'invoice_id',
            render: (text) => <span className="font-medium text-gray-900">{text}</span>,
        },
        {
            title: 'Email',
            dataIndex: 'email',
            key: 'email',
            width: 250,
            render: (text) => <span className="font-medium text-gray-900">{text}</span>
        },
        {
            title: 'Amount',
            dataIndex: 'total_amount',
            key: 'total_amount',
            render: (text) => <span className="font-medium text-gray-900">{text}</span>,
        },
        {
            title: 'Balance',
            dataIndex: 'current_balance',
            key: 'current_balance',
            render: (text) => <span className="font-medium text-gray-900">{text}</span>,
        },
        {
            title: 'Tax',
            dataIndex: 'total_tax',
            key: 'total_tax',
            render: (text) => <span className="font-medium text-gray-900">{text}</span>,
        },
        {
            title: 'Currency',
            dataIndex: 'currency_code',
            key: 'currency_code',
            render: (text) => <span className="font-medium text-gray-900">{text}</span>,
        },
        {
            title: 'Due Date',
            dataIndex: 'due_date',
            key: 'due_date',
            render: (text) => <span className="font-medium text-gray-900">{text}</span>,
        },
        {
            title: 'Status',
            dataIndex: 'status',
            key: 'status',
            render: (text) => <Tag color="blue-inverse" key={text}>{text.toUpperCase()}</Tag>,
        }
    ];

    // Prepare the dataSource for the Custom Table component
    const dataSource = invoiceData?.map((invoice, index) => ({
        key: index+1,
        ...invoice,
    })) || [];

    return (
        <AppLayout>
            <div className="py-8">
                <div className="mx-auto max-w-8xl sm:px-6 lg:px-8">

                    <Button disabled={loading.invoice} onClick={invoiceListing} color="primary" variant="outlined" className={"mb-3"}>
                        <svg className="mt-0.5 mr-1" width={20} viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.3935 5.37371C18.0253 6.70569 19.8979 10.7522 18.5761 14.4118C17.6363 17.0135 15.335 18.7193 12.778 19.0094M12.778 19.0094L13.8253 17.2553M12.778 19.0094L14.4889 20M9.60651 18.6263C5.97465 17.2943 4.10205 13.2478 5.42394 9.58823C6.36371 6.98651 8.66504 5.28075 11.222 4.99059M11.222 4.99059L10.1747 6.74471M11.222 4.99059L9.51114 4"
                                  stroke= { loading.invoice ? "grey" : "#1677FF"} strokeLinecap="round" strokeLinejoin="round"/>
                        </svg>
                        Sync Invoices
                    </Button>

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="relative overflow-x-auto shadow-md sm:rounded-lg">

                            <div className="relative overflow-x-auto" style={{height: "88vh", overflowY: "auto"}}>
                                <CustomTable columns={columns} dataSource={dataSource} pagination={false} loading={loading.invoice}/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
