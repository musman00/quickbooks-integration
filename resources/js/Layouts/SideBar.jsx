import React, { useEffect, useState } from 'react';
import { MailOutlined, CalendarOutlined, LinkOutlined } from '@ant-design/icons';
import { Menu } from 'antd';
import { Link, usePage } from '@inertiajs/react';

const SideBar = () => {
    const { url } = usePage();
    const [selectedKey, setSelectedKey] = useState('');

    // Mapping of route names to their corresponding keys
    const routeMap = {
        'quickbook.dashboard': 'quickbook.dashboard',
        'quickbook.chartofaccounts': 'quickbook.chartofaccounts',
        'quickbook.expenses': 'quickbook.expenses',
        'quickbook.invoices': 'quickbook.invoices',
    };

    useEffect(() => {
        // Find the key of the current route dynamically
        const activeKey = Object.keys(routeMap).find(routeName => route().current(routeName));
        if (activeKey) {
            setSelectedKey(routeMap[activeKey]);
        }
    }, [url]);

    const items = [
        {
            key: 'quickbook.dashboard',
            icon: <MailOutlined />,
            label: (
                <Link href={route('quickbook.dashboard')}>
                    Customers
                </Link>
            ),
        },
        {
            key: 'quickbook.chartofaccounts',
            icon: <CalendarOutlined />,
            label: (
                <Link href={route('quickbook.chartofaccounts')}>
                    Chart of Accounts
                </Link>
            ),
        },
        {
            key: 'quickbook.expenses',
            icon: <LinkOutlined />,
            label: (
                <Link href={route('quickbook.expenses')}>
                    Expenses
                </Link>
            ),
        },
        {
            key: 'quickbook.invoices',
            icon: <LinkOutlined />,
            label: (
                <Link href={route('quickbook.invoices')}>
                    Invoices
                </Link>
            ),
        },
    ];

    return (
        <Menu
            className={"custom-menu"}
            mode="inline"
            theme="light"
            selectedKeys={[selectedKey]}
            items={items}
        />
    );
};

export default SideBar;
