import React from 'react';
import { Space, Table as AntTable, Tag } from 'antd';

export default function CustomTable({ columns, dataSource, pagination, loading }) {
    return (
        <AntTable
            sticky
            scroll={{x: '100%', scrollToFirstRowOnChange: true }}
            columns={columns} dataSource={dataSource} pagination={pagination} loading={loading} />
    );
}
