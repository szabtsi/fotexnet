import React from "react";
import { Outlet } from "react-router";
import { Layout } from "antd";

const AppLayout = () => {
    const { Content, Header } = Layout;

    return (
        <Layout style={{ minHeight: "100dvh" }}>
            <Header>
                <p style={{ color: "white" }}>Fotexnet - Felföldi Szabolcs</p>
            </Header>
            <Content
                style={{
                    padding: "0 48px",
                    marginTop: 64,
                }}
            >
                <div
                    style={{
                        background: "#fff",
                        minHeight: 280,
                        padding: 24,
                        borderRadius: 5,
                    }}
                >
                    <Outlet />
                </div>
            </Content>
        </Layout>
    );
};

export default AppLayout;
