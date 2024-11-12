import AppLogo from '@/Components/AppLogo.jsx';
import {Link, router} from '@inertiajs/react';
import SideBar from "@/Layouts/SideBar.jsx";
import {Content, Header} from "antd/es/layout/layout.js";
import {Button, Layout} from "antd";
import Sider from "antd/es/layout/Sider.js";

function LogoutOutlined() {
    return null;
}

export default function AppLayout({ children }) {
    const logout = () => {
        router.post(route("quickbook-oauth.logout"))
    }

    return (
        <Layout className="min-h-screen bg-gray-100">
            <Header className="bg-white border-b border-gray-100">
                <div className="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 justify-between items-center px-4">
                        <div className="flex items-center">
                            <div className="flex shrink-0 items-center">
                                <Link href="/public">
                                    <AppLogo className="w-5/12 fill-current text-gray-500" />
                                </Link>
                            </div>
                        </div>

                        <div className="flex items-center space-x-8 sm:-my-px sm:ms-10">
                            <Button
                                type="default"
                                icon={<LogoutOutlined />}
                                onClick={logout}
                                className="flex items-center"
                            >
                                Log Out
                            </Button>
                        </div>
                    </div>
                </div>
            </Header>

            <Layout>
                <Sider width={250} className="site-layout-background">
                    <SideBar />
                </Sider>

                <Content className="bg-gray-100">
                    {children}
                </Content>
            </Layout>
        </Layout>
    );
}
