import { useEffect, useState } from "react";
import axios from "axios";
import { Card, Col, Pagination, Row, Spin } from "antd";
import { Link } from "react-router";

function App() {
    const [movies, setMovies] = useState([]);
    const [meta, setMeta] = useState({
        total: 0,
        current: 1,
        links: [],
        perPage: 5,
    });
    const [loading, setLoading] = useState(false);

    const { Meta } = Card;

    useEffect(() => {
        fetchMovies();
    }, []);

    const fetchMovies = async (page = 1) => {
        setLoading(true);

        try {
            const response = await axios.get(
                "http://localhost:80/api/v1/movies",
                {
                    params: {
                        page,
                    },
                }
            );

            if (response.status === 200) {
                const { data } = response.data;

                setMovies(data.data);
                setMeta({
                    total: data.total,
                    current: data.current_page,
                    links: data.links,
                    perPage: data.per_page,
                });
            }
            setLoading(false);
        } catch (error) {
            console.log(error);
            setLoading(false);
        }
    };

    return (
        <Spin spinning={loading}>
            <h3>Movies</h3>

            <Row gutter={[16, 16]}>
                {movies?.map((movie) => (
                    <Col span={6} key={movie.id}>
                        <Link to={`/movies/${movie.id}`}>
                            <Card
                                key={movie.id}
                                hoverable
                                style={{ width: 240, minHeight: 300 }}
                                cover={
                                    <img alt={movie.title} src={movie.cover} />
                                }
                            >
                                <Meta
                                    title={movie.title}
                                    description={movie.description}
                                />
                            </Card>
                        </Link>
                    </Col>
                ))}
            </Row>

            <div style={{ display: "flex", justifyContent: "center" }}>
                <Pagination
                    style={{ margin: "20px" }}
                    total={meta.total}
                    current={meta.current}
                    pageSize={meta.perPage}
                    onChange={(page) => {
                        fetchMovies(page);
                    }}
                />
            </div>
        </Spin>
    );
}

export default App;
