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
            <div className="container">
                <div className="row my-4">
                    <h3 className="text-center">Movies</h3>

                    <p className="text-center">
                        Check out our collection of movies. Click on a movie to
                        see more!
                    </p>
                </div>
                <div className="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 justify-content-center">
                    {movies?.map((movie) => (
                        <div className="col" key={movie.id}>
                            <Link
                                to={`/movies/${movie.id}`}
                                style={{ textDecoration: "none" }}
                            >
                                <Card
                                    key={movie.id}
                                    hoverable
                                    style={{ width: 240, height: "100%" }}
                                    /* cover={
                                        <img
                                            alt={movie.title}
                                            src={movie.cover}
                                        />
                                    } */
                                    cover={
                                        <div
                                            style={{
                                                width: "100%",
                                                height: 200,
                                                backgroundColor: "grey",
                                            }}
                                        ></div>
                                    }
                                >
                                    <Meta
                                        title={movie.title}
                                        description={movie.description}
                                    />
                                </Card>
                            </Link>
                        </div>
                    ))}
                </div>
            </div>

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
