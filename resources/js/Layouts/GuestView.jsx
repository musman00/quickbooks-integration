import {Card, Col, Row} from 'antd';

export default function Guest({children}) {
    return (
        <Row
            justify="center"
            align="middle"
            style={{minHeight: '100vh'}}>
            <Col span={8}>
                <Card title="Connect to Quickbooks" bordered={true} style={{padding: '30px', textAlign: 'center'}}>
                    {children}
                </Card>
            </Col>
        </Row>
    );
}
