import AppLayout from '@/Layouts/AppLayout.jsx';
import React, { useState, useEffect } from 'react';
import axios from "axios";
import CustomTable from "@/Components/CustomTable.jsx";
import {Tag} from "antd";
import { message } from 'antd';

export default function ChartOfAccount() {
    const [state, setState] = useState({
        chartOfAccounts: [],
        loadingChartOfAccounts: false
    });

    const chartOfAccountListing = async () => {
        setState(data => ({ ...data, loadingChartOfAccounts: true }));
        try {
            const response = await axios.get(route("api.quickbook.chartofaccounts"));
            setState(data => ({
                ...data,
                chartOfAccounts: response.data.success ? response.data.data : []
            }));
            if (!response.data.success) {
                message.error(response.data.message);
            }
        } catch (error) {
            message.error('Error while fetching chart of accounts');
        } finally {
            setState(data => ({ ...data, loadingChartOfAccounts: false }));
        }
    };

    useEffect(() => {
        (async () => {
            await chartOfAccountListing();
        })();
    }, []);


    const columns = [
        {
            title: 'Account ID',
            dataIndex: 'account_id',
            key: 'account_id',
            render: (text) => <span className="font-medium text-gray-900">{text}</span>,
        },
        {
            title: 'Account Name',
            dataIndex: 'account_name',
            key: 'account_name',
            render: (text) => <span className="font-medium text-gray-900">{text}</span>,
        },
        {
            title: 'Account Type',
            dataIndex: 'account_type',
            key: 'account_type',
            render: (text) => <Tag color="#4b5563" key={text}>{text.toUpperCase()}</Tag>,
        },
        {
            title: 'Balance',
            dataIndex: 'current_balance',
            key: 'current_balance',
            render: (balance) => <span className="font-medium text-gray-900">{balance}</span>,
        },
        {
            title: 'Currency',
            dataIndex: 'currency_code',
            key: 'currency_code',
            render: (text) => <span className="font-medium text-gray-900">{text}</span>,
        },
        {
            title: 'Status',
            dataIndex: 'status',
            key: 'status',
            render: (status) => <Tag color="blue-inverse" key={status}>{status ? 'Active' : "Inactive"}</Tag>,
        },
    ];

    const dataSource = state.chartOfAccounts?.map((account, index) => ({
        key: index + 1,
        ...account,
    })) || [];

    return (
        <AppLayout>
            <div className="py-8">
                <div className="mx-auto max-w-8xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="relative overflow-x-auto shadow-md sm:rounded-lg" style={{height: "88vh", overflowY: "auto"}}>
                            <CustomTable
                                columns={columns}
                                dataSource={dataSource}
                                pagination={false}
                                loading={state.loadingChartOfAccounts}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
